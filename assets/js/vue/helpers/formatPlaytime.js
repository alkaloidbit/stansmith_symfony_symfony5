// import dayjs from 'dayjs';
// import duration from 'dayjs/plugin/duration';
// import relativeTime from 'dayjs/plugin/relativeTime';
// import fr from 'dayjs/locale/fr';

import humanizeDuration from 'humanize-duration';

// dayjs.extend(duration);
// dayjs.extend(relativeTime);

const frenchHumanizer = humanizeDuration.humanizer({
    language: 'fr',
    units: ['h', 'm'],
    round: true,
});

export default function (playtime) {
    // return humanizeDuration(playtime * 1000, { language: 'fr' }, { largest: '2' });
    // return dayjs.duration(playtime, 'seconds').locale('fr').humanize();
    // console.log('playtime: ', playtime);
    return frenchHumanizer(playtime * 1000);
}
