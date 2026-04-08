<script setup lang="ts">
import { RouterLink } from "vue-router";
import AppShellHeader from "../components/AppShellHeader.vue";

const kpis = [
  { label: "Open tickets", value: "128", trend: "+14 today" },
  { label: "Collection rate", value: "86.4%", trend: "Target 90%" },
  { label: "Occupancy", value: "91%", trend: "3 compounds below target" },
  { label: "Marketplace GMV", value: "$42.8K", trend: "7% month over month" }
];

const workstreams = [
  "Resident onboarding and unit linking",
  "Maintenance and complaint SLA tracking",
  "Invoice lifecycle and payment reconciliation",
  "Vendor scoring and AI report scheduling",
  "Super admin storage and backup oversight"
];

const managementPanels = [
  {
    title: "Compound operations",
    body: "Buildings, units, occupancy, and staff role assignment from a single tenant-aware workspace."
  },
  {
    title: "Resident experience",
    body: "Announcements, complaints, visitor approvals, and booking flows surfaced with response targets."
  },
  {
    title: "Financial control",
    body: "Invoice status, overdue balances, commission tracking, and reconciliation-ready payment summaries."
  }
];
</script>

<template>
  <main class="min-h-screen bg-ink px-6 py-8 text-paper md:px-12">
    <AppShellHeader
      eyebrow="Admin Preview"
      title="Executive command center"
      subtitle="A demo surface for compound managers and operators to monitor SLAs, revenue, occupancy, marketplace performance, and staff activity."
    />

    <div class="mx-auto mt-8 max-w-7xl space-y-8">
      <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article v-for="kpi in kpis" :key="kpi.label" class="glass-card">
          <div class="text-sm uppercase tracking-[0.25em] text-sand/70">{{ kpi.label }}</div>
          <div class="mt-5 text-4xl font-semibold text-white">{{ kpi.value }}</div>
          <div class="mt-3 text-sm text-paper/70">{{ kpi.trend }}</div>
        </article>
      </section>

      <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <article class="rounded-[2rem] border border-white/10 bg-deep-teal/70 p-6 shadow-panel">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Operational focus</div>
          <div class="mt-6 space-y-4">
            <div v-for="item in workstreams" :key="item" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm leading-7 text-paper/85">
              {{ item }}
            </div>
          </div>
        </article>

        <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Build direction</div>
          <ul class="mt-6 space-y-4 text-sm leading-7 text-paper/80">
            <li>Tenant-aware route guards for resident, admin, and super admin contexts.</li>
            <li>Server-driven dashboard widgets with KPI cards and chart slots.</li>
            <li>Shared RTL-safe table, form, and notification components.</li>
            <li>Desktop wrapper will point to this admin surface with secure auth persistence.</li>
          </ul>
        </article>
      </section>

      <section class="grid gap-4 md:grid-cols-3">
        <article v-for="panel in managementPanels" :key="panel.title" class="glass-card">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">{{ panel.title }}</div>
          <p class="mt-4 text-sm leading-7 text-paper/75">{{ panel.body }}</p>
        </article>
      </section>

      <section class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Portal cross-section</div>
            <h2 class="mt-3 text-2xl font-semibold text-white">Show the client both operator and resident journeys</h2>
          </div>

          <div class="flex flex-wrap gap-4">
            <RouterLink class="primary-cta" to="/resident">Open resident preview</RouterLink>
            <RouterLink class="secondary-cta" to="/">Back to overview</RouterLink>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>
