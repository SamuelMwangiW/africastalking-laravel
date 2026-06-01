import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "AT Laravel SDK",
  description: "An unofficial Laravel SDK for Africa's Talking APIs — SMS, Airtime, Payments, Voice, USSD, and more.",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Documentation', link: '/start/installation' }
    ],

    sidebar: [
      {
        text: 'Getting Started',
        items: [
          { text: 'Installation', link: '/start/installation' },
          { text: 'About This Package', link: '/start/about' },
          { text: 'Callback Requests', link: '/start/requests' },
          { text: 'SMS Notifications', link: '/start/notification' },
        ]
      },
      {
        text: 'Application',
        items: [
          { text: 'Application Balance', link: '/app/balance' },
        ]
      },
      {
        text: 'SMS',
        items: [
          { text: 'Bulk SMS', link: '/sms/sending' },
          { text: 'Premium SMS', link: '/sms/premium' },
          { text: 'On-Demand SMS', link: '/sms/ondemand' },
        ]
      },
      {
        text: 'Airtime',
        items: [
          { text: 'Send Airtime', link: '/airtime/send' },
        ]
      },
      {
        text: 'USSD',
        items: [
          { text: 'USSD Sessions', link: '/ussd/interact' },
        ]
      },
      {
        text: 'Insights',
        items: [
          { text: 'SIM Swap Detection', link: '/insights/sim-swap' },
        ]
      },
      {
        text: 'Payments',
        items: [
          { text: 'Mobile Checkout', link: '/payments/mobile-checkout' },
          { text: 'Wallet Balance', link: '/payments/wallet-balance' },
          { text: 'Stash Top-Up', link: '/payments/stash-topup' },
        ]
      },
      {
        text: 'Voice',
        items: [
          { text: 'Making Calls', link: '/voice/calls' },
          { text: 'Voice Responses (IVR)', link: '/voice/responses' },
          { text: 'Synthesized Speech', link: '/voice/attributes' },
        ]
      },
      {
        text: 'WebRTC',
        items: [
          { text: 'Browser Token', link: '/webrtc/token' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/SamuelMwangiW/africastalking-laravel' }
    ]
  }
})
