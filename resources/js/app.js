import {createApp} from 'vue'
import CommentComponent from './components/CommentComponent.vue'

// createApp(CommentComponent).mount("#commentComponentApp")

const app = createApp({});

app.component('CommentComponent', CommentComponent);

app.mount("#app");
