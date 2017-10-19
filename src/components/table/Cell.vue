<template>
  <div>
    <div v-if="type === 'number'" class="number">
      {{value*1}}
    </div>
    <div v-else-if="type === 'decimal'" class="number">
      {{(value*1).toFixed(2)}}
    </div>
    <div v-else-if="type === 'html'" v-html="value">
    </div>
    <div v-else-if="type === 'boolean'" >
      {{value*1 ? 'True' : 'False'}}
    </div>
    <div v-else-if="type === 'check'" >
      <i v-if="value * 1 === 0" class="fa fa-close text-danger" aria-hidden="true"></i>
      <i v-else class="fa fa-check text-success" aria-hidden="true"></i>
    </div>
    <div v-else-if="type === 'button'" >
      <button v-if="if_condition(row_data)" @click="setting['on_click']($event, row_data, row_index)" v-html="setting['label']" v-bind:class="setting['class']" @click.stop type="button" class="btn"></button>
    </div>
    <div v-else-if="type === 'multiple-button'" >
      <template v-for="button in setting['buttons']">
          <button v-if="button.if_condition(row_data)" @click="button.on_click($event, row_data, row_index)" v-html="button['label']" v-bind:class="button['class']"  @click.stop type="button" class="btn ml-2 mb-2"></button>
      </template>
    </div>
    <div v-else>
      {{value}}
    </div>
  </div>
</template>
<script>
  export default{
    name: '',
    create(){
    },
    mounted(){
    },
    data(){
      return {
      }
    },
    props: ['type', 'value', 'setting', 'row_data', 'if_condition', 'row_index'],
    methods: {
    }
  }
</script>
<style scoped>
  .number{
    text-align: right
  }
</style>
