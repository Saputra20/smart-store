// Views - Todos
import Index from '@/views/modules/categories/Index'
import Form from '@/views/modules/categories/Form'

const module = {
  name: 'Kategori',
  link: 'categories',
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
    {
      path     : 'create',
      name     : `create-${module.link}`,
      component: Form,
      meta     : { label: `Tambah ${module.name}`, action: 'create' },
    },
    {
      path     : 'edit/:id',
      name     : `edit-${module.link}`,
      component: Form,
      meta     : { label: `Ubah ${module.name}`, action: 'update' },
    },
  ],
}
