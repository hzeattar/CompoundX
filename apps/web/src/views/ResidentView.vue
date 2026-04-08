<script setup lang="ts">
import { RouterLink } from "vue-router";
import AppShellHeader from "../components/AppShellHeader.vue";

const quickStats = [
  { label: "Outstanding balance", value: "IQD 1,250,000", helper: "Due in 4 days" },
  { label: "Maintenance tickets", value: "3 open", helper: "1 high priority" },
  { label: "Visitor approvals", value: "6 today", helper: "2 waiting confirmation" },
  { label: "Amenity bookings", value: "2 upcoming", helper: "Gym and pool" }
];

const billRows = [
  { month: "April 2026", category: "Service fee", amount: "IQD 450,000", status: "Pending" },
  { month: "April 2026", category: "Electricity", amount: "IQD 180,000", status: "Pending" },
  { month: "March 2026", category: "Service fee", amount: "IQD 450,000", status: "Paid" }
];

const activityFeed = [
  "Maintenance team scheduled AC inspection for tomorrow at 10:00 AM.",
  "Security approved your guest pre-registration for Unit 305.",
  "Emergency notice: water pressure maintenance in Building B at 6:00 PM.",
  "Marketplace listing for used sofa is awaiting admin approval."
];

const shortcuts = [
  "Pay monthly bills and review fines history",
  "Track maintenance and complaint status in real time",
  "Approve guests, riders, and temporary visitor passes",
  "Book amenities with slot and capacity protection"
];
</script>

<template>
  <main class="min-h-screen bg-ink px-6 py-8 text-paper md:px-12">
    <AppShellHeader
      eyebrow="Resident Preview"
      title="Resident service portal"
      subtitle="A resident-facing workspace for billing, maintenance, bookings, guest approvals, community notices, and marketplace participation."
    />

    <div class="mx-auto mt-8 max-w-7xl space-y-8">
      <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article v-for="stat in quickStats" :key="stat.label" class="glass-card">
          <div class="text-sm uppercase tracking-[0.25em] text-sand/70">{{ stat.label }}</div>
          <div class="mt-4 text-3xl font-semibold text-white">{{ stat.value }}</div>
          <div class="mt-3 text-sm text-paper/70">{{ stat.helper }}</div>
        </article>
      </section>

      <section class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur">
          <div class="flex items-center justify-between gap-4">
            <div>
              <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Unified billing</div>
              <h2 class="mt-3 text-2xl font-semibold text-white">Invoices, utilities, and penalties</h2>
            </div>
            <span class="secondary-cta">Payment-ready API</span>
          </div>

          <div class="mt-6 overflow-hidden rounded-[1.6rem] border border-white/10">
            <table class="w-full border-collapse text-left text-sm text-paper/80">
              <thead class="bg-white/5 text-paper/55">
                <tr>
                  <th class="px-4 py-4 font-medium">Cycle</th>
                  <th class="px-4 py-4 font-medium">Type</th>
                  <th class="px-4 py-4 font-medium">Amount</th>
                  <th class="px-4 py-4 font-medium">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in billRows" :key="`${row.month}-${row.category}`" class="border-t border-white/10">
                  <td class="px-4 py-4">{{ row.month }}</td>
                  <td class="px-4 py-4">{{ row.category }}</td>
                  <td class="px-4 py-4">{{ row.amount }}</td>
                  <td class="px-4 py-4">
                    <span :class="['status-pill', row.status === 'Paid' ? 'status-pill-success' : 'status-pill-pending']">
                      {{ row.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </article>

        <article class="rounded-[2rem] border border-white/10 bg-deep-teal/70 p-6 shadow-panel">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Resident shortcuts</div>
          <div class="mt-6 space-y-4">
            <div v-for="item in shortcuts" :key="item" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm leading-7 text-paper/85">
              {{ item }}
            </div>
          </div>
        </article>
      </section>

      <section class="grid gap-6 lg:grid-cols-[0.92fr_1.08fr]">
        <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Community stream</div>
          <div class="mt-6 space-y-4">
            <div v-for="item in activityFeed" :key="item" class="timeline-item">
              {{ item }}
            </div>
          </div>
        </article>

        <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur">
          <div class="text-sm uppercase tracking-[0.3em] text-sand/70">Cross-portal flow</div>
          <h2 class="mt-3 text-2xl font-semibold text-white">How residents connect to operations</h2>
          <div class="mt-5 grid gap-4 md:grid-cols-2">
            <div class="feature-band">
              <div class="feature-band-label">Onboarding</div>
              <p class="feature-band-copy">Invitation code, phone match, or future QR link to bind the account to the correct unit.</p>
            </div>
            <div class="feature-band">
              <div class="feature-band-label">Operations</div>
              <p class="feature-band-copy">Maintenance, complaints, bookings, and emergency notices all stay visible from one dashboard.</p>
            </div>
            <div class="feature-band">
              <div class="feature-band-label">Payments</div>
              <p class="feature-band-copy">Residents can review invoices, pay fees, and confirm receipts from gateway-backed flows later.</p>
            </div>
            <div class="feature-band">
              <div class="feature-band-label">Marketplace</div>
              <p class="feature-band-copy">Listings, approvals, and internal community commerce feed commissions back to the operator.</p>
            </div>
          </div>

          <div class="mt-6 flex flex-wrap gap-4">
            <RouterLink class="primary-cta" to="/admin">View admin operations</RouterLink>
            <RouterLink class="secondary-cta" to="/">Back to product overview</RouterLink>
          </div>
        </article>
      </section>
    </div>
  </main>
</template>
