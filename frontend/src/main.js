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

const users = JSON.parse(localStorage.getItem("users")) || [];

// Check if admin user already exists
const adminExists = users.some(
  (user) => user.id === "admin-psmu3ghd" || user.email === "admin@me.com"
);

// Add default admin user only if it doesn't exist
if (!adminExists) {
  const defaultUser = {
    id: "admin-psmu3ghd",
    name: "admin",
    email: "admin@me.com",
    password: "000000",
    role: "admin",
    date: new Date().toISOString().split("T")[0],
  };

  users.push(defaultUser);
  localStorage.setItem("users", JSON.stringify(users));
}

app.component("Header", Header);
app.component("Footer", Footer);
app.component("Hero", Hero);
app.component("DetailsModal", DetailsModal);
// app.component("PrimaryBtn", PrimaryBtn);
app.mount("#app");
