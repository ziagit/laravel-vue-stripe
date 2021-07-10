<template>
  <div class="container">
    <b-card header="Refund Charge" class="mt-5">
      <form @submit.prevent="submit">
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
  }),
  methods: {
    submit() {
      this.isSubmitting = true;
      axios
        .get("api/charge/refund")
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
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;
  font-family: "Roboto";
  height: 40px;

  padding: 10px 12px;

  border-bottom: 1px solid #ddd;
  /* border-radius: 4px; */
  background-color: white;

  /* box-shadow: 0 1px 3px 0 #e6ebf1; */
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

/*  .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        } */

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
.StripeElement {
  border: solid 1px #ddd;
  border-radius: 3px;
}
</style>