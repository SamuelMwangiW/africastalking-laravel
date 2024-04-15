import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "Africa's Talking PHP SDK Docs",
  description: "Africa's Talking PHP SDK Docs",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      {text: 'Home', link: '/'},
      {text: 'Examples', link: '/markdown-examples'}
    ],

    sidebar: [
      {
        text: 'Examples',
        items: [
          {text: 'Markdown Examples', link: '/markdown-examples'},
          {text: 'Runtime API Examples', link: '/api-examples'}
        ]
      }
    ],

    search: {
      provider: 'local'
    },

    socialLinks: [
      {icon: 'github', link: 'https://github.com/SamuelMwangiW/africastalking-laravel'}
    ],
    editLink: {
      pattern: 'https://github.com/SamuelMwangiW/africastalking-laravel/edit/add-docs/docs/:path'
    },
    lastUpdated: {}
  }
})
