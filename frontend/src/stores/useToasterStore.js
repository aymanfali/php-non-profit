import { defineStore } from "pinia";
import { useToast } from "vue-toastification";

const toast = useToast();

export const useToasterStore = defineStore("toaster-store", {
  state: {
    count: 0,
  },
  mutations: {
    increment(state) {
      state.count++;
    },
  },
  actions: {
    increment(context) {
      context.commit("increment");
      toast.success("incremented!");
    },
  },
});
