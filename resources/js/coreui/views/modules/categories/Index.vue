/* eslint-disable vue/no-use-v-if-with-v-for */
<template>
  <div class="animated fadeIn">
    <b-card>
      <div slot="header">
        <b-row>
          <b-col>
            <strong>{{ $route.meta.label }}</strong>
          </b-col>
          <b-col align="right">
            <b-row>
              <b-col sm="12">
                <button
                  class="btn btn-primary"
                  @click="get()"
                >
                  <i class="fa fa-refresh" /> Load Data
                </button>
                <router-link
                  :to="'/'+config.api+'/create'"
                  title="Tambah Data"
                  class="btn btn-primary"
                >
                  <i class="fa fa-plus" /> Tambah Data
                </router-link>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
      </div>
      <b-row>
        <div class="col-sm-12 mb-2">
          <div class="col-sm-3 pull-right no-padding">
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
        <b-col sm="12">
          <table class="table b-table">
            <thead>
              <tr>
                <th
                  v-for="header in config.headers"
                  :key="header.id"
                  :width="header.width"
                >
                  <a
                    v-if="header.value"
                    class="sort dark-font"
                    href="javascript:void(0)"
                    @click="sort(header.value)"
                  >
                    {{ header.title }}
                    <i
                      :id="header.value"
                      class="fa fa-sort sorting"
                    />
                  </a>
                  <a
                    v-if="!header.value"
                    :id="header.value"
                    class="sort dark-font"
                    href="javascript:void(0)"
                  >
                    {{ header.title }}
                  </a>
                </th>
              </tr>
            </thead>
            <tbody v-if="config.total">
              <tr
                v-for="data in config.datas"
                :key="data.id"
              >
                <td>{{ data.name }}</td>
                <td>{{ data.created_at }}</td>
                <td align="center">
                  <router-link
                    :to="'/'+config.api+'/edit/'+data.id"
                    title="Ubah"
                    class="btn btn-light"
                  >
                    <i class="fa fa-pencil" />
                  </router-link>
                  <button
                    title="Hapus"
                    class="btn btn-light"
                    @click="destroy(data.id)"
                  >
                    <i class="fa fa-trash" />
                  </button>
                </td>
              </tr>
            </tbody>
            <tbody v-if="!config.total">
              <td
                :colspan="config.headers.length"
                align="center"
              >
                Tidak ada data.
              </td>
            </tbody>
            <tfoot v-if="config.total">
              <tr>
                <td :colspan="config.headers.length">
                  <div class="pull-left">
                    <p>Total {{ config.total }} data</p>
                  </div>
                  <div class="pull-right pagination">
                    <b-pagination
                      v-model="config.page"
                      :total-rows="config.total"
                      :per-page="config.limit"
                      @change="gotoPage"
                    />
                  </div>
                </td>
              </tr>
            </tfoot>
          </table>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>

<script>
import table from '@/shared/table'
export default {
  data () {
    return {
      config: {
        api    : 'categories',
        total  : 0,
        datas  : [],
        orderBy: 'id',
        sortBy : 'desc',
        offset : 0,
        limit  : 10,
        page   : 1,
        search : { keyword: '' },
        headers: [
          {
            title: 'Nama',
            value: 'name',
            width: '15%',
          },
          {
            title: 'Tanggal Pembuatan',
            value: 'created_at',
            width: '15%',
          },
          {
            title: '',
            value: false,
            width: '15%',
          },
        ],
        response: {
          variant: this.$route.params.variant,
          message: this.$route.params.message,
        },
      },
    }
  },
  created () {
    const _ = this
    _.get()
  },
  methods: {
    get () {
      table.get(this)
    },
    sort (orderBy) {
      table.sort(this, orderBy)
    },
    gotoPage (page) {
      table.gotoPage(this, page)
    },
    destroy (id) {
      table.destroy(this, id)
    },
  },
}
</script>
