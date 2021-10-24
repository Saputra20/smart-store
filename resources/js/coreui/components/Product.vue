<template>
  <b-col
    sm="6"
    md="4"
    lg="4"
    xl="3"
  >
    <div class="card">
      <svg
        class="bd-placeholder-img card-img-top"
        width="100%"
        height="230"
        xmlns="http://www.w3.org/2000/svg"
        aria-label="Placeholder: Image cap"
        preserveAspectRatio="xMidYMid slice"
        role="img"
      >
        <rect
          width="100%"
          height="100%"
          fill="#868e96"
        />
      </svg>

      <div class="card-body">
        <b-badge
          pill
          variant="primary"
          class="mb-0"
        >
          {{ data.category.name }}
        </b-badge>
        <b-card-title class="mb-3">
          {{ data.name }}
        </b-card-title>
        <b-row>
          <b-col>
            <b-card-text class="small text-muted">
              Stok: {{ data.stock }}
            </b-card-text>
          </b-col>
          <b-col align="right">
            <b-card-text>
              {{ idr(data.price) }}
            </b-card-text>
          </b-col>
        </b-row>
      </div>
    </div>
  </b-col>
</template>

<script>
export default {
  props: {
    data: {
      type    : Object,
      required: true,
      default : () => {},
    },
  },
  methods: {
    idr (number) {
      return new Intl.NumberFormat('id-ID', {
        style   : 'currency',
        currency: 'IDR',
      }).format(number)
    },
  },
}
</script>
