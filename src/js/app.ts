import App from '@/vue/App.vue';
import { createApp } from 'vue';

// App main
const main = async () => {
    // Create our vue instance
    const app = createApp(App);
    // Mount the app
    const root = app.mount('#component-container');

    return root;
};

// Execute async function
main().then( (root) => {
    console.log('Loaded.');
});
