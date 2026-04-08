<script setup lang="ts">
import { useI18n } from "vue-i18n";
import { RouterLink } from "vue-router";
import { useAppStore } from "../stores/app";

const { t } = useI18n();
const appStore = useAppStore();

const moduleCards = [
  "Tenant-aware admin and resident portals",
  "Billing, penalties, utilities, and payment adapters",
  "Marketplace, disputes, and configurable commission sharing",
  "Maintenance, complaints, booking, visitors, and notifications",
  "Super admin, white-label branding, and AI insight rules"
];

const docCards = [
  {
    title: "Architecture",
    body: "Layered backend, schema-per-tenant isolation, queues, storage, and integration boundaries."
  },
  {
    title: "Milestones",
    body: "A 16-week plan mapped to foundational, operational, financial, and handover phases."
  },
  {
    title: "PoC",
    body: "Proof strategy for host-based tenant resolution and schema isolation before business modules."
  }
];
</script>

<template>
  <main class="min-h-screen bg-ink text-paper">
    <section class="relative overflow-hidden px-6 py-8 md:px-12">
      <div class="hero-orb hero-orb-left"></div>
      <div class="hero-orb hero-orb-right"></div>

      <header class="mx-auto flex max-w-7xl flex-col gap-5 rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur md:flex-row md:items-center md:justify-between">
        <div>
          <div class="text-sm uppercase tracking-[0.35em] text-sand/80">{{ t("brand") }}</div>
          <div class="mt-2 text-2xl font-semibold text-white">{{ t("subtitle") }}</div>
        </div>

        <div class="flex items-center gap-3">
          <button class="lang-chip" @click="appStore.setLocale('en')">EN</button>
          <button class="lang-chip" @click="appStore.setLocale('ar')">AR</button>
          <button class="lang-chip" @click="appStore.setLocale('ku')">KU</button>
        </div>
      </header>

      <div class="mx-auto mt-10 grid max-w-7xl gap-8 lg:grid-cols-[1.3fr_0.9fr]">
        <div class="space-y-6">
          <p class="w-fit rounded-full border border-sand/30 bg-sand/10 px-4 py-2 text-xs uppercase tracking-[0.3em] text-sand">
            Phase 1 Foundation
          </p>
          <h1 class="max-w-4xl text-5xl font-semibold leading-tight text-white md:text-7xl">
            {{ t("heroTitle") }}
          </h1>
          <p class="max-w-3xl text-lg leading-8 text-paper/80 md:text-xl">
            {{ t("heroCopy") }}
          </p>

          <div class="flex flex-wrap gap-4">
            <RouterLink class="primary-cta" to="/admin">{{ t("viewAdmin") }}</RouterLink>
            <span class="secondary-cta">{{ t("architecture") }}</span>
            <span class="secondary-cta">{{ t("delivery") }}</span>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <article v-for="card in docCards" :key="card.title" class="glass-card">
              <div class="text-sm uppercase tracking-[0.3em] text-sand/70">{{ card.title }}</div>
              <p class="mt-4 text-sm leading-7 text-paper/75">{{ card.body }}</p>
            </article>
          </div>
        </div>

        <aside class="panel-stack">
          <div class="metric-card">
            <div class="metric-label">Tenancy</div>
            <div class="metric-value">Schema</div>
            <div class="metric-copy">Isolated PostgreSQL schema per compound with automated routing.</div>
          </div>
          <div class="metric-card">
            <div class="metric-label">Financial safety</div>
            <div class="metric-value">Atomic + Idempotent</div>
            <div class="metric-copy">Payments, invoices, and marketplace transactions protected against duplicate execution.</div>
          </div>
          <div class="metric-card">
            <div class="metric-label">Delivery</div>
            <div class="metric-value">16 Weeks</div>
            <div class="metric-copy">Six execution milestones from foundation PoC to UAT and handover.</div>
          </div>
        </aside>
      </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-4 px-6 pb-16 md:grid-cols-2 xl:grid-cols-5">
      <article v-for="moduleCard in moduleCards" :key="moduleCard" class="module-card">
        <div class="module-dot"></div>
        <p class="text-sm leading-7 text-paper/80">{{ moduleCard }}</p>
      </article>
    </section>
  </main>
</template>
