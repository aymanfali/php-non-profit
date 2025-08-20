import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import "./assets/main.css";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import Hero from "./components/Hero.vue";
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";
import DetailsModal from "./components/Dashboard/DetailsModal.vue";
// import PrimaryBtn from './components/Dashboard/Buttons/PrimaryBtn.vue';

const options = {
  position: POSITION.TOP_RIGHT,
};

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
app.use(Toast, options);

app.component("Header", Header);
app.component("Footer", Footer);
app.component("Hero", Hero);
app.component("DetailsModal", DetailsModal);

app.mount("#app");
