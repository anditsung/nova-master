Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-master',
      path: '/nova-master',
      component: require('./components/Tool'),
    },
  ])
})
