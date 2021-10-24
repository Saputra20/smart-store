// Views - Todos
import Index from '@/views/modules/products/Index'

const module = {
  name: 'Produk',
  link: 'products',
}

export default {
  path     : `/${module.link}`,
  component: { render (c) { return c('router-view') } },
  meta     : { label: module.name },
  children : [
    {
      path     : '/',
      name     : module.link,
      component: Index,
      meta     : { label: module.name },
    },
  ],
}
