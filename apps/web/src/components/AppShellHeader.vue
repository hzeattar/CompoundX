<script setup lang="ts">
import { computed } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import { useAppStore } from "../stores/app";

defineProps<{
  eyebrow: string;
  title: string;
  subtitle: string;
}>();

const route = useRoute();
const { t } = useI18n();
const appStore = useAppStore();

const navItems = computed(() => [
  { label: t("navHome"), to: "/" },
  { label: t("navResident"), to: "/resident" },
  { label: t("navAdmin"), to: "/admin" }
]);

const isActive = (to: string) => route.path === to;
</script>

<template>
  <header class="mx-auto flex max-w-7xl flex-col gap-6 rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur md:p-7">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
      <div class="max-w-3xl">
        <div class="text-sm uppercase tracking-[0.35em] text-sand/75">{{ eyebrow }}</div>
        <h1 class="mt-3 text-4xl font-semibold text-white md:text-6xl">{{ title }}</h1>
        <p class="mt-4 max-w-2xl text-base leading-8 text-paper/72 md:text-lg">{{ subtitle }}</p>
      </div>

      <div class="flex items-center gap-3 self-start">
        <button class="lang-chip" @click="appStore.setLocale('en')">EN</button>
        <button class="lang-chip" @click="appStore.setLocale('ar')">AR</button>
        <button class="lang-chip" @click="appStore.setLocale('ku')">KU</button>
      </div>
    </div>

    <nav class="flex flex-wrap gap-3">
      <RouterLink
        v-for="item in navItems"
        :key="item.to"
        :to="item.to"
        :class="['nav-pill', { 'nav-pill-active': isActive(item.to) }]"
      >
        {{ item.label }}
      </RouterLink>
    </nav>
  </header>
</template>
