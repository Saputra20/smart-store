/* eslint-disable unicorn/prefer-query-selector */
/* eslint-disable unicorn/prevent-abbreviations */
export default {
  get ($self) {
    const _       = $self
    const params  = {
      limit  : _.config.limit,
      offset : _.config.offset,
      orderBy: _.config.orderBy,
      sortBy : _.config.sortBy,
    }
    const search  = _.config.search
    const options = Object.assign(params, search)
    _.$axios.get(_.config.api, { params: options }).then((res) => {
      if (res.data.success) {
        _.config.datas = res.data.data.rows
        _.config.total = res.data.data.meta.total_data
      }
    })
  },
  sort ($self, orderBy) {
    const _          = $self
    const elm        = document.getElementById(orderBy)
    document.querySelectorAll('.sorting').forEach((element) => {
      if (orderBy !== element.id) {
        element.classList.remove('fa-sort-desc', 'fa-sort-asc')
        element.classList.add('fa-sort')
      }
    })
    elm.classList.remove('fa-sort', `fa-sort-${_.config.sortBy}`)
    _.config.orderBy = orderBy
    _.config.sortBy  = (_.config.sortBy === 'asc') ? 'desc' : 'asc'
    elm.classList.add(`fa-sort-${_.config.sortBy}`)
    _.get()
  },
  gotoPage ($self, page) {
    const _         = $self
    _.config.offset = (parseInt(page) - 1) * parseInt(_.config.limit)
    _.get()
  },
  destroy ($self, id) {
    const _ = $self
    _.$swal.fire({
      title             : 'Apakah kamu yakin ingin menghapus data?',
      type              : 'warning',
      showCancelButton  : true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor : '#d33',
      confirmButtonText : 'Ya',
      cancelButtonText  : 'Tidak',
    }).then((res) => {
      if (res.value) {
        _.$axios.delete(`${_.config.api}/${id}`).then((res) => {
          _.response = {
            variant: (res.data.status) ? 'success' : 'danger',
            message: res.data.message,
          }
          _.get()
        })
      }
    })
  },
}
