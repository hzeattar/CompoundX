<script setup lang="ts">
import { computed } from "vue";
import { RouterLink } from "vue-router";
import { useI18n } from "vue-i18n";
import AppShellHeader from "../components/AppShellHeader.vue";

const { t } = useI18n();

const experienceCards = computed(() => [
  {
    title: t("residentTitle"),
    body: t("residentCopy"),
    cta: t("viewResident"),
    to: "/resident"
  },
  {
    title: t("adminTitle"),
    body: t("adminCopy"),
    cta: t("viewAdmin"),
    to: "/admin"
  }
]);

const moduleCards = computed(() => [
  t("moduleOne"),
  t("moduleTwo"),
  t("moduleThree"),
  t("moduleFour"),
  t("moduleFive"),
  t("moduleSix")
]);

const timelineCards = computed(() => [
  { title: t("timelineOneTitle"), body: t("timelineOneBody") },
  { title: t("timelineTwoTitle"), body: t("timelineTwoBody") },
  { title: t("timelineThreeTitle"), body: t("timelineThreeBody") },
  { title: t("timelineFourTitle"), body: t("timelineFourBody") }
]);

const metrics = computed(() => [
  { label: t("metricTenancy"), value: "Schema", body: t("metricTenancyBody") },
  { label: t("metricFinance"), value: "Atomic + Idempotent", body: t("metricFinanceBody") },
  { label: t("metricDelivery"), value: "16 Weeks", body: t("metricDeliveryBody") }
]);
</script>

<template>
  <main class="min-h-screen bg-ink px-6 py-8 text-paper md:px-12">
    <section class="relative overflow-hidden">
      <div class="hero-orb hero-orb-left"></div>
      <div class="hero-orb hero-orb-right"></div>

      <AppShellHeader
        :eyebrow="t('brand')"
        :title="t('heroTitle')"
        :subtitle="t('heroCopy')"
      />

      <div class="mx-auto mt-8 grid max-w-7xl gap-8 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-6">
          <p class="w-fit rounded-full border border-sand/30 bg-sand/10 px-4 py-2 text-xs uppercase tracking-[0.3em] text-sand">
            {{ t("phaseLabel") }}
          </p>

          <div class="flex flex-wrap gap-4">
            <RouterLink class="primary-cta" to="/resident">{{ t("viewResident") }}</RouterLink>
            <RouterLink class="secondary-cta" to="/admin">{{ t("viewAdmin") }}</RouterLink>
            <a class="secondary-cta" href="#timeline">{{ t("delivery") }}</a>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <article v-for="card in experienceCards" :key="card.to" class="glass-card">
              <div class="text-sm uppercase tracking-[0.3em] text-sand/70">{{ card.title }}</div>
              <p class="mt-4 text-sm leading-7 text-paper/75">{{ card.body }}</p>
              <RouterLink :to="card.to" class="mt-5 inline-flex text-sm font-semibold text-sand">
                {{ card.cta }}
              </RouterLink>
            </article>
          </div>
        </div>

        <aside class="panel-stack">
          <div v-for="metric in metrics" :key="metric.label" class="metric-card">
            <div class="metric-label">{{ metric.label }}</div>
            <div class="metric-value">{{ metric.value }}</div>
            <div class="metric-copy">{{ metric.body }}</div>
          </div>
        </aside>
      </div>
    </section>

    <section class="mx-auto mt-10 max-w-7xl">
      <div class="section-heading">
        <div class="section-eyebrow">{{ t("modules") }}</div>
        <h2 class="section-title">{{ t("modulesTitle") }}</h2>
      </div>

      <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article v-for="moduleCard in moduleCards" :key="moduleCard" class="module-card">
          <div class="module-dot"></div>
          <p class="text-sm leading-7 text-paper/80">{{ moduleCard }}</p>
        </article>
      </div>
    </section>

    <section id="timeline" class="mx-auto mt-12 max-w-7xl">
      <div class="section-heading">
        <div class="section-eyebrow">{{ t("delivery") }}</div>
        <h2 class="section-title">{{ t("timelineTitle") }}</h2>
      </div>

      <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article v-for="card in timelineCards" :key="card.title" class="glass-card">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">{{ card.title }}</div>
          <p class="mt-4 text-sm leading-7 text-paper/75">{{ card.body }}</p>
        </article>
      </div>
    </section>
  </main>
</template>
