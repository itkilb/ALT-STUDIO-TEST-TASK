<template>
<div class="">
    <Header></Header>
    <div class="punny position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Punny headline</h1>
      <p class="lead fw-normal">And an even wittier subheading to boot. Jumpstart your marketing efforts with this example based on Apple’s marketing pages.</p>
      <a class="btn btn-outline-secondary" href="#">Coming soon</a>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
  </div>
  <div class="pricing bg-dark">
      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
      <h1 class="display-4 fw-normal text-light">Pricing</h1>
      <p class="fs-5 text-muted text-light">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It’s built with default Bootstrap components and utilities with little customization.</p>
    </div>
    <div class="pricing-cards mx-auto">
        <Pricing></Pricing>
    </div>
  </div>

</div>

</template>
<script>
import Header from './Header';
import Pricing from './Pricing.vue';
export default {
  name: 'Main',
  components: {
    Header, Pricing,
  },
};
</script>

<style scoped>
.pricing-header {
    max-width: 700px;
}
.pricing {
    height: 100vh;
}
.pricing-cards {
    max-width: 1500px;
}
</style>
