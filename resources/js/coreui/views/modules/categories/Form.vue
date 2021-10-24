/* eslint-disable handle-callback-err */
/* eslint-disable unicorn/prevent-abbreviations */
/* eslint-disable unicorn/prevent-abbreviations */
<template>
  <form
    class="form-horizontal"
    @submit.prevent="save"
  >
    <div class="wrapper">
      <div class="animated fadeIn mb-3">
        <b-card>
          <div slot="header">
            <strong>{{ $route.meta.label }}</strong>
          </div>
          <b-row>
            <div
              v-if="response.message"
              class="col-sm-12 mb-10"
            >
              <b-alert
                show
                :variant="response.variant"
              >
                {{ response.message }}
              </b-alert>
            </div>
            <b-col sm="12">
              <b-form-group :class="{ 'is-invalid': errors.has('Name')}">
                <label for="name">* Name</label>
                <b-form-input
                  v-model="model.name"
                  v-validate="'required'"
                  type="text"
                  name="Name"
                />
                <div v-if="errors.has('Name')">
                  <p class="text-danger">
                    {{ errors.first('Name') }}
                  </p>
                </div>
              </b-form-group>
            </b-col>
            <b-col sm="">
              <div class="card-button">
                <div
                  class="card-button-body"
                  align="right"
                >
                  <b-row>
                    <b-col sm="12">
                      <router-link
                        :to="'/'+config.api"
                        class="btn btn-primary"
                      >
                        <i class="fa fa-arrow-left" /> Kembali
                      </router-link>
                      <b-button
                        type="submit"
                        variant="primary"
                        class="px-4"
                      >
                        <i class="fa fa-save" /> Simpan
                      </b-button>
                    </b-col>
                  </b-row>
                </div>
              </div>
            </b-col>
          </b-row>
        </b-card>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  data () {
    return {
      config  : { api: 'categories', action: this.$route.meta.action },
      response: {
        variant: '',
        message: '',
      },
      model : { name: '' },
      params: { category: {} },
    }
  },
  created () {
    const _ = this
    _.getById()
  },
  methods: {
    getById () {
      const _ = this
      if (_.$route.params.id) {
        _.$axios.get(`${_.config.api}/${_.$route.params.id}`).then((response) => {
          _.model.name = response.data.data.name
        })
      }
    },
    save () {
      const _           = this
      _.params.FormData = new FormData()
      for (const i in this.model)
        _.params.FormData.append(i, this.model[i])

      _.$validator.validate().then((valid) => {
        if (valid) {
          if (_.config.action === 'create') {
            _.$axios.post(_.config.api, _.params.FormData).then((response) => {
              _.$router.push({
                name  : _.config.api,
                params: {
                  variant: (response.data.status) ? 'success' : 'danger',
                  message: response.data.message,
                },
              })
            // eslint-disable-next-line handle-callback-err
            }).catch((error) => {
              _.response = {
                variant: 'danger',
                message: error.response.data.message,
              }
            })
          } else {
            _.$axios.post(`${_.config.api}/${_.$route.params.id}`, _.params.FormData, { params: { _method: 'PUT' } }).then((response) => {
              _.$router.push({
                name  : _.config.api,
                params: {
                  variant: (response.data.status) ? 'success' : 'danger',
                  message: response.data.message,
                },
              })
            // eslint-disable-next-line handle-callback-err
            }).catch((error) => {
              _.response = {
                variant: 'danger',
                message: error.response.data.message,
              }
            })
          }
        }
      })
    },
  },
}
</script>
