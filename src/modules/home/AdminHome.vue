<template>
  <div>
    <div class="row">
      <div class="col-md-4 col-lg-2 hidden-sm">
        <img src="../../assets/img/logo.png" class="img-fluid float-right">
      </div>
      <div class="col-md-8 col-lg-10">
        <h1><strong>Welcome to iLinya!</strong></h1>
        <h3>
          A new way of serving your customer. No more waiting lines, no more wasted time!
        </h3>
        <p>
          Feel free to explore iLinya. If you dont know where to start, just follow the instructions we prepared for you below.
        </p>
        <div class="alert alert-info">
          <strong>Tips:</strong>
          <ul>
            <li>You can always hover on <i class="fa fa-question-circle"></i> to show explaination on things that may not understand well.</li>
            <li>The iLinya team is always ready to answer to your questions and listen to your problems and suggestions</li>
            <li>There is no such thing such as a fake smile. So don't worry about over doing it :)</li>
          </ul>
        </div>
      </div>
    </div>
    <hr>

      <div class="row">
        <div class="col-sm-12 col-md-6">
          <h2>Form Management</h2>
          <p><em>Queue Form</em> is a form where your customer must fill up their information that you require before they can avail to your service and get their <em>Q-card</em>. So by the time they are on the counter, basic information or details are already prepared.</p>
        </div>
        <div class="col-sm-12 col-md-6 embed-responsive embed-responsive-16by9 embed-responsive-item">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/6hjPYH0743M?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    <hr>

      <div class="row">
        <div class="col-sm-12 col-md-6"></div>
        <div class="col-sm-12 col-md-6">
          <h2>Counter</h2>
          <p>The counter is where you can manage the virtual queueing lines. You can add, edit, remove a <em>Q-card</em>. You can also notify your customer ahead of time to come to the counter. Need to announce something? You can also do it there! Lastly, you can export your data.</p>
        </div>
      </div>
  </div>
</template>
<script>
export default {
  components: {
  },
  mounted() {
    this.initDummy()
  },
  data() {
    return {

    }
  },
  methods: {
    initDummy() {

    }
  }
}
</script>
<style scoped>
.table-large td {
  padding: 5px
}
</style>
