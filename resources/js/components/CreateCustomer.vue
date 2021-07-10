<template>
  <div class="container">
    <b-card header="Create Customer" class="mt-5">
      <form @submit.prevent="submit">
        <b-form-group>
          <b-form-input v-model="form.name" placeholder="Name"></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input v-model="form.email" placeholder="Email"></b-form-input>
        </b-form-group>
        <div ref="card"></div>
        <div class="text-right mt-3">
          <b-spinner variant="primary" v-if="isSubmitting"></b-spinner>
          <b-button v-else type="submit" variant="primary">Submit</b-button>
        </div>
      </form>
    </b-card>
  </div>
</template>

<script>
var stripe = Stripe(process.env.MIX_STRIPE_KEY);
var elements = stripe.elements();
var style = {
  base: {
    color: "#32325d",
    fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#aab7c4",
    },
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a",
  },
};
var card = undefined;
export default {
  data: () => ({
    isSubmitting:false,
    form: {
      name: null,
      email: null,
    },
  }),
  mounted: function () {
    card = elements.create("card", {
      style: style,
      hidePostalCode: true,
    });
    card.mount(this.$refs.card);
  },
  methods: {
    submit() {
      this.isSubmitting=true;
      stripe.createToken(card).then((result) => {
        if (result.error) {
          console.log("error happend when getting token");
        } else {
          this.handleToken(result.token);
        }
      });
    },
    handleToken(token) {
      console.log("token: ", token);
      this.form.stripeToken = token.id;
      axios
        .post("api/customer/create",this.form)
        .then((res) => {
          this.isSubmitting=false;
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