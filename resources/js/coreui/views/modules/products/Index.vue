<template>
  <div class="animated fadeIn mb-3">
    <b-row>
      <div class="col-sm-12 mb-4">
        <div class="col-sm-3 pull-left p-0 mb-2">
          <div class="input-group">
            <select
              id="basicSelect"
              v-model="config.category"
              name=""
              class="form-control p-1"
              @change="changeCategory"
            >
              <option value="null">
                Semua
              </option>
              <option
                v-for="(category, key) in select.categories"
                :key="key"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-sm-3 pull-right p-0">
          <div class="input-group">
            <input
              v-model="config.search.keyword"
              type="text"
              placeholder="Search..."
              class="form-control"
              @keyup="get()"
            >
            <div class="input-group-prepend">
              <div
                class="input-group-text"
                @click="get()"
              >
                <i class="fa fa-search" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-row>
    <b-row>
      <product
        v-for="data in config.datas"
        :key="data.id"
        :data="data"
      />
    </b-row>
    <div class="card-button">
      <div class="card-button-body">
        <div class="pull-left pl-3">
          <p>Total {{ config.total }} data</p>
        </div>
        <div class="pull-right pagination pr-3">
          <b-pagination
            v-model="config.page"
            :total-rows="config.total"
            :per-page="config.limit"
            @change="gotoPage"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Product from '@/components/Product'
import table from '@/shared/table'
export default {
  components: { Product },
  data () {
    return {
      config: {
        api     : 'products',
        select  : 'categories',
        datas   : [],
        total   : 0,
        offset  : 0,
        limit   : 12,
        orderBy : 'id',
        sortBy  : 'desc',
        page    : 1,
        search  : { keyword: '' },
        category: null,
      },
      model : {},
      select: { categories: {} },
    }
  },
  created () {
    const _ = this
    _.get()
    _.getCategories()
  },
  methods: {
    get () {
      const _       = this
      const params  = {
        limit   : _.config.limit,
        offset  : _.config.offset,
        orderBy : _.config.orderBy,
        sortBy  : _.config.sortBy,
        category: _.config.category,
      }
      const search  = _.config.search
      const options = Object.assign(params, search)
      _.$axios.get(_.config.api, { params: options }).then((response) => {
        if (response.data.success) {
          _.config.datas = response.data.data.rows
          _.config.total = response.data.data.meta.total_data
        }
      })
    },
    getCategories () {
      const _ = this
      _.$axios.get(_.config.select).then((response) => {
        _.select.categories = response.data.data.rows
      })
    },
    gotoPage (page) {
      table.gotoPage(this, page)
    },
    changeCategory () {
      const _ = this
      _.get()
    },
  },
}
</script>
