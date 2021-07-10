<template>
  <div class="container">
    <b-card header="Charge Customer" class="mt-5">
      <form @submit.prevent="submit">
        <b-form-group>
          <b-form-input
            v-model="form.order_title"
            placeholder="Order title"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input
            v-model="form.amount"
            placeholder="Amount"
          ></b-form-input>
        </b-form-group>
        <div class="text-right mt-3">
          <b-spinner variant="primary" v-if="isSubmitting"></b-spinner>
          <b-button v-else type="submit" variant="primary">Submit</b-button>
        </div>
      </form>
    </b-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    isSubmitting: false,
    form: {
      order_title:null,
      amount: 0,
    },
  }),
  mounted: function () {},
  methods: {
    submit() {
      this.isSubmitting = true;
      axios
        .post("api/customer/charge", this.form)
        .then((res) => {
          this.isSubmitting = false;
          console.log("res: ", res.data);
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style>
.container {
  width: 500px;
}
</style>