import { createI18n } from "vue-i18n";

const messages = {
  en: {
    brand: "CompoundX",
    subtitle: "Smart compound lifecycle management",
    heroTitle: "One platform for the full residential compound lifecycle.",
    heroCopy:
      "Operations, billing, community services, marketplace, AI insights, and white-label management on a single API-first foundation.",
    viewAdmin: "Open admin preview",
    architecture: "Architecture baseline",
    delivery: "Delivery plan",
    modules: "Phase 1 modules",
    adminTitle: "Admin command center",
    adminCopy:
      "This starter view gives us a clean UI foundation for KPI dashboards, resident operations, and super admin workflows."
  },
  ar: {
    brand: "CompoundX",
    subtitle: "إدارة ذكية لدورة حياة المجمع السكني",
    heroTitle: "منصة واحدة لإدارة دورة حياة المجمع السكني بالكامل.",
    heroCopy:
      "التشغيل، الفوترة، خدمات السكان، السوق الداخلي، مؤشرات الذكاء، والهوية البيضاء فوق بنية API-First واحدة.",
    viewAdmin: "فتح معاينة لوحة الإدارة",
    architecture: "الهيكل المعماري",
    delivery: "خطة التنفيذ",
    modules: "وحدات المرحلة الأولى",
    adminTitle: "مركز قيادة الإدارة",
    adminCopy:
      "هذه الواجهة الأولية تعطينا قاعدة UI نظيفة لبناء لوحات المؤشرات، عمليات السكان، ووظائف السوبر أدمن."
  },
  ku: {
    brand: "CompoundX",
    subtitle: "بەڕێوەبردنی زیرەکی ژیانی کۆمەڵگای نیشتەجێبوون",
    heroTitle: "یەک پلاتفۆرم بۆ تەواوی ژیانی کۆمەڵگای نیشتەجێبوون.",
    heroCopy:
      "کارگێڕی، پسوولە، خزمەتگوزاری دانیشتووان، بازاڕ، هۆشیاری دروستکراو و ناسنامەی تایبەت لەسەر بنەمای API-First.",
    viewAdmin: "کردنەوەی پێشبینینی بەڕێوەبەر",
    architecture: "تەلارى تەکنیکی",
    delivery: "پلانی جێبەجێکردن",
    modules: "مۆدیولەکانی قۆناغی یەکەم",
    adminTitle: "ناوەندی فرمانی بەڕێوەبردن",
    adminCopy:
      "ئەم دەستپێکی UI ـە بنەمایەکی پاکمان پێدەدات بۆ دروستکردنی داشبۆرد، کارەکانی دانیشتووان و سوپەر ئەدمین."
  }
};

export const i18n = createI18n({
  legacy: false,
  locale: "en",
  fallbackLocale: "en",
  messages
});
