import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "AT Laravel",
  description: "This is an unofficial Laravel SDK for interacting with Africa's Talking APIs",
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
          { text: 'Installing', link: '/start/installation' },
          { text: 'About', link: '/start/about' },
          { text: 'HTTP Requests', link: '/start/requests' },
          { text: 'Notification', link: '/start/notification' },
        ]
      },
      {
        text: 'Applicaton',
        items: [
          { text: 'Application Balance', link: '/app/balance' },
        ]
      },
      {
        text: 'SMS',
        items: [
          { text: 'Sending Bulk Messages', link: '/sms/sending' },
          { text: 'Sending Premium Messages', link: '/sms/premium' },
          { text: 'Sending OnDemand', link: '/sms/ondemand' },
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
          { text: 'Interact with USSD', link: '/ussd/interact' },
        ]
      },
      {
        text: 'Insights',
        items: [
          { text: 'Insights (SIM Swap)', link: '/insights/sim-swap' },
        ]
      },
      {
        text: 'Payments',
        items: [
          { text: 'Mobile Checkout', link: '/payments/mobile-checkout' },
          { text: 'Wallet Balance', link: '/payments/wallet-balance' },
          { text: 'Stash top up', link: '/payments/stash-topup' },
        ]
      },
      {
        text: 'Voice',
        items: [
          { text: 'Voice Responses', link: '/voice/responses' },
          { text: 'Synthesized Speech Attributes', link: '/voice/attributes' },
          { text: 'Making Calls', link: '/voice/calls' },
        ]
      },
      {
        text: 'WebRTC',
        items: [
          { text: 'WebRTC Token', link: '/webrtc/token' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/SamuelMwangiW/africastalking-laravel' }
    ]
  }
})
