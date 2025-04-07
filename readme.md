# Vercel Revalidate

[![WordPress Tested Up To: 6.7](https://img.shields.io/badge/WP-6.7-blue.svg)](https://wordpress.org/)
[![PHP 7.4–8.2 Compatible](https://img.shields.io/badge/PHP-7.4--8.2-green.svg)](https://www.php.net/)
[![License: GPLv2](https://img.shields.io/badge/license-GPLv2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

Trigger ISR (Incremental Static Regeneration) from WordPress to Vercel on post update. Built for headless WordPress + Next.js.

---

## 🔥 Features

- ✅ Automatic revalidation on post publish/update
- ✅ Secure HMAC signature verification by default
- ✅ Compatible with **Next.js Pages Router & App Router**
- ✅ Works with both JavaScript and TypeScript APIs
- ✅ Manual revalidation interface
- ✅ Admin logs with status, date, and export
- ✅ Language support: English 🇺🇸 / French 🇫🇷
- ✅ Clean, modern admin UI (SVG icon included)

---

## 🛠 Installation

1. Upload the plugin folder to `/wp-content/plugins/vercel-revalidate`
2. Activate via the WordPress admin
3. Go to `Settings > Vercel Revalidate`
4. Enter your revalidation endpoint and shared secret
5. Ensure your Next.js app has a secure `/api/revalidate` endpoint (see Help tab)

---

## 📘 Documentation

Find examples for:
- Pages Router (JS & TS)
- App Router (JS & TS)

All included in the plugin's **Help & Integration** tab 🧩

---

## 🖼️ Screenshots

### 1. Plugin Settings
![Plugin Settings](./assets/screenshot-1.webp)

### 2. Revalidation Logs
![Revalidation Logs](./assets/screenshot-2.webp)

### 3. Help & Integration Tab
![Integration Help](./assets/screenshot-3.webp)

---

## 🛡️ Security

This plugin does not send secrets in plain text. Every request is signed with HMAC-SHA256 using your shared key. Unauthorized requests are automatically rejected.

---

## 🧾 Changelog

See [CHANGELOG.md](./CHANGELOG.md) for full release history.

Latest: **v1.4**
- HMAC security added ✅
- Integration examples included ✅
- UI improvement + PHP 8.2 support ✅

---

## 💼 Pro Version (Coming Soon)

The Pro version will include:
- Analytics Dashboard (charts & trends)
- Slack/webhook alerts
- Monthly email reports
- Extended logs + filtering
- License manager

Stay tuned!

---

## 📜 License

This plugin is licensed under the GPLv2 or later.

