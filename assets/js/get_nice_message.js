export default function (exclamationCount, context) {
    return `Hello Webpack Encore! You are in ${context}. Edit me in assets/app.js${'!'.repeat(exclamationCount)}`;
}
