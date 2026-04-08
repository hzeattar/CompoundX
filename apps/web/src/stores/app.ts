import { defineStore } from "pinia";
import { ref } from "vue";
import { i18n } from "../i18n";

const STORAGE_KEY = "compoundx.locale";

export const useAppStore = defineStore("app", () => {
  const locale = ref(localStorage.getItem(STORAGE_KEY) || "en");

  const setLocale = (value: "en" | "ar" | "ku") => {
    locale.value = value;
    i18n.global.locale.value = value;
    localStorage.setItem(STORAGE_KEY, value);
  };

  setLocale(locale.value as "en" | "ar" | "ku");

  return {
    locale,
    setLocale
  };
});
