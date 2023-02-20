version: 1.2

# How to use:

cd to root_dir, then `syse`

`yarn dev-server-local --hot`

# Admin Side

cd to root_dir/my-admin, then `yarn start`

# Handling File Upload

+ https://api-platform.com/docs/core/file-upload/#making-a-request-to-the-media_objects-endpoint

- [x] Test making a post request to the /media_objects endpoint

After posting the data we receive a response like that:

```json
{
	"@type": "https://shema.org/MediaObject",
	"@id": "/media_objects/<id>",
	"contentUrl": "<url>"
}
```

+ https://api-platform.com/docs/core/file-upload/#linking-a-mediaobject-resource-to-another-resource

- [X] Test sending a POST request to create a new Album, linked with the previously uploaded cover

`POST /api/albums`

```json
{
  "title": "BlaBla",
  "artist": "/api/artists/5",
  "cover": [
    "/api/media_objects/68",
  ],
  "date": "1998",
  "active": true
}
```


## Thumbnails and placeholder images creation

When uploading a cover file, we automatically create thumbnails and placeholder images,

thanks to https://github.com/dustin10/VichUploaderBundle/blob/master/docs/events/events.md:

` # src/EventSubscriber/VichSubscriber.php`

thumbnail and placeholder are property of the MediaObject entity.





