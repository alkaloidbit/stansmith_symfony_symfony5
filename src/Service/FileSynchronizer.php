<?php

namespace App\Service;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Track;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class FileSynchronizer.
 *
 * @author yourname
 */
class FileSynchronizer
{
    private $metadataHelper;

    private $helperService;

    private $trackRepository;

    private $artistRepository;

    private $albumRepository;

    private $finder;

    private $em;

    /**
     * @var string
     */
    private $filePath;

    /**
     * A (MD5) hash of the file's path.
     * This value is unique, and can be used to query a Track.
     *
     * @var string
     */
    private $fileHash;

    /**
     * @var \SplFileInfo
     */
    private $splFileInfo;

    /**
     * @var int
     */
    private $fileModifiedTime;

    /**
     * The track model associated with current file.
     *
     * @var Track|null
     */
    private $trackEntity;

    private $mediaImageService;

    public function __construct(MetadataHelper $metadataHelper, TrackRepository $trackRepository, ArtistRepository $artistRepository, AlbumRepository $albumRepository, HelperService $helperService, EntityManagerInterface $em, MediaImageService $mediaImageService)
    {
        $this->metadataHelper = $metadataHelper;
        $this->helperService = $helperService;
        $this->trackRepository = $trackRepository;
        $this->artistRepository = $artistRepository;
        $this->albumRepository = $albumRepository;
        $this->finder = new Finder();
        $this->em = $em;
        $this->mediaImageService = $mediaImageService;
    }

    public function setFile($path)
    {
        $this->splFileInfo = $path instanceof \SplFileInfo ? $path : new \SplFileInfo($path);

        // file modification time
        $this->fileModifiedTime = $this->splFileInfo->getMTime();

        $this->filePath = $this->splFileInfo->getPathname();

        $this->fileHash = $this->helperService->getFileHash($this->filePath);

        $this->trackEntity = $this->trackRepository->findOneBy(['id' => $this->fileHash]);

        return $this;
    }

    /**
     * @return Synchronization status of the file
     *
     * 1 - Entity exists.
     * 2 - New file synced.
     * 3 - No Metadata to sync
     */
    public function synchronize($dryrun = false)
    {
        if ($dryrun) {
            return $this->getFileInfo(false);
        } else {
            // file is not new
            // return !$this->trackEntity
            if (!$this->isNewFile()) {
                return 1;
            }

            // cannot read file tags
            // no ID3 tags (no vorbiscomment) to sync: (Arnaud tracks or cover file)
            if (!$info = $this->getFileInfo()) {
                return 3;
            }

            // file is new.
            // get or Create new Artist
            if (!$artist = $this->artistRepository->findOneBy(['name' => $info['artist']])) {
                $artist = new Artist();
                $artist->setName($info['artist']);
                $this->em->persist($artist);
                $this->em->flush();
            }

            // get or Create new album
            if (!$album = $this->albumRepository->findOneBy(['title' => $info['album']])) {
                $album = new Album();
                $album->setTitle($info['album']);
                $album->setDate($info['date']);

                // multi-artist album
                if (isset($info['albumartist'])) {
                    if (!$albumArtist = $this->artistRepository->findOneBy(['name' => $info['albumartist']])) {
                        $albumArtist = new Artist();
                        $albumArtist->setName($info['albumartist']);
                        $this->em->persist($albumArtist);
                        $this->em->flush();
                    }

                    $artist = $albumArtist;
                }

                $album->setArtist($artist);
                $album->setActive(true);

                $this->em->persist($album);
                $this->em->flush();

                // Cover collection === 0
                if (0 === count($album->getCovers())) {
                    $this->generateAlbumCover($album, $info);
                }
            }

            // Create new track
            if (!$this->trackEntity
                || $this->trackEntity->getMTime() !== $this->fileModifiedTime) {
                $this->trackEntity = new Track();

                $this->trackEntity->setId($this->fileHash);
                $this->trackEntity->setPath($this->filePath);
                $this->trackEntity->setMtime($this->fileModifiedTime);
                $this->trackEntity->setMimeType($info['mime_type']);
                $this->trackEntity->setTitle($info['title']);
                $this->trackEntity->setFileformat($info['fileformat']);

                $this->trackEntity->setMetaArtist($info['artist']);
                $this->trackEntity->setMetaAlbum($info['album']);
                $this->trackEntity->setMetaDate($info['date']);
                $this->trackEntity->setMetaGenre($info['genre']);
                $this->trackEntity->setMetaTrackNumber($info['track_number']);
                $this->trackEntity->setMetaFilesize($info['filesize']);
                $this->trackEntity->setMetaPlaytimeSeconds($info['playtime_seconds']);
                $this->trackEntity->setMetaPlaytimeString($info['playtime_string']);

                $this->trackEntity->setArtist($artist);
                $this->trackEntity->setAlbum($album);

                $this->em->persist($this->trackEntity);
                $this->em->flush();
            }

            return 2;
        }
    }

    public function generateAlbumCover(Album $album, ?array $albumInfo): void
    {
        // if 'cover' key exists in track metadata
        if (array_key_exists('cover', $albumInfo)) {
            dd($albumInfo);
        }

        if ($cover = $this->getSplFileCoverUnderSameDirectory()) {
            $extension = pathinfo($cover, PATHINFO_EXTENSION);
            $origname = $cover->getBasename('.'.$extension);
            $this->mediaImageService->writeCover($album, file_get_contents($cover->getPathname()), $origname, $extension);
        }
    }

    public function isNewFile(): bool
    {
        return !$this->trackEntity;
    }

    public function getFileInfo($dryrun = false)
    {
        $info = $this->metadataHelper->analyze($this->filePath);

        if ($dryrun) {
            return $info;
        }

        if (!isset($info['comments'])) {
            return;
        }

        $props = [];

        try {
            $props = $this->extractPropsFromCommentsHtml($info['comments']);
        } catch (\Exception $e) {
            echo $this->filePath.'extractPropsFromCommentsHtml is throwing exception handling this file: '.$e->getMessage();
        }

        $props = array_merge(
            $props,
            [
                'filesize' => $info['filesize'],
                'playtime_seconds' => $info['playtime_seconds'],
                'playtime_string' => $info['playtime_string'],
                'mime_type' => $info['mime_type'],
                'fileformat' => $info['fileformat'],
            ]
        );

        return $props;
    }

    public function getSplFileCoverUnderSameDirectory()
    {
        $result = array_values(
            iterator_to_array(
                $this->finder->depth(0)
                    ->create()
                    ->in(dirname($this->filePath))
                    ->files()
                    ->name('/(cov|fold)er|\.(jpe?g|png)$/i')
            )
        );

        $splinfo = $result ? $result[0] : null;

        return $splinfo;
    }

    public function getCoverFileUnderSameDirectory(): ?string
    {
        $matches = array_keys(
            iterator_to_array(
                $this->finder->create()
                    ->depth(0)
                    ->files()
                    ->name('/(cov|fold)er|\.(jpe?g|png)$/i')
                    ->in(dirname($this->filePath))
            )
        );

        $cover = $matches ? $matches[0] : null;

        return $cover && $this->isImage($cover) ? $cover : null;
    }

    private function isImage(string $path): bool
    {
        try {
            return (bool) \exif_imagetype($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function extractPropsFromCommentsHtml(array $comments)
    {
        if (isset($comments['date'][0]) && $comments['date'][0]) {
            $date = $comments['date'][0];
        } elseif (isset($comments['year'][0]) && $comments['year'][0]) {
            $date = $comments['year'][0];
        } else {
            $date = '';
        }

        if (isset($comments['track_number'][0]) && $comments['track_number'][0]) {
            $track_number = $comments['track_number'][0];
        } elseif (isset($comments['tracknumber'][0]) && $comments['tracknumber'][0]) {
            $track_number = $comments['tracknumber'][0];
        } else {
            $track_number = '';
        }

        return [
            'title' => isset($comments['title']) ? $comments['title'][0] : '',
            'artist' => $comments['artist'][0],
            'albumartist' => isset($comments['albumartist']) ? $comments['albumartist'][0] : null,
            'album' => $comments['album'][0],
            'genre' => (isset($comments['genre'][0]) && $comments['genre'][0]) ? $comments['genre'][0] : '',
            'date' => $date,
            'track_number' => $track_number,
        ];
    }
}
