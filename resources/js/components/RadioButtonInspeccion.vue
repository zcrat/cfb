<template>
    <div class="form-group">
        <div class="custom-radios">
            <div>
                <input type="radio" class="color-1" :id="[id+'1']" :name="[nombre]" value="1"   @click="d(1)" v-model.number="val">
                <label :for="[id+'1']" >
                    <span class="circulo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Octicons-check.svg"  alt="Checked Icon" />
                    </span>
                </label>
            </div>
            <div>
                <input type="radio" class="color-2" :id="[id+'2']" :name="[nombre]" value="2"  @click="d(2)" v-model.number="val">
                <label :for="[id+'2']">
                    <span class="triangulo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Octicons-check.svg"  alt="Checked Icon" />
                    </span>
                </label>
            </div>
            <div>
                <input type="radio" class="color-3" :id="[id+'3']" :name="[nombre]" value="3"   @click="d(3)" v-model.number="val">
                <label :for="[id+'3']">
                    <span class="circulo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Octicons-check.svg" alt="Checked Icon" />
                    </span>
                </label>
            </div>
            <label>{{message}}</label>
        </div>
    </div>
</template>

<script>
export default {
    name: 'RadioButtonInspeccion',
    props: {
        message: '',
        nombre: '',
        id: '',
        val:''
    },
    data() {
        return{
            value: 0
        }
    },
    methods:{
        d(n){
            this.value = n;
            this.$emit('added', this.value);
        }
    }
};
</script>

<style lang="sass">
$color-1: #e74c3c
$color-2: transparent
$color-3: #2ecc71

.custom-radios

  div
    display: inline-block


  input[type="radio"]
    display: none

    + label
      color: #333
      font-family: Arial, sans-serif
      font-size: 14px

      .triangulo
        width: 0px
        height: 0px
        border-left: 10px solid transparent
        border-right: 10px solid transparent
        border-bottom: 20px solid #f1c40f

      .circulo
         border-radius: 50%
         width: 20px
         height: 20px


      span
        display: inline-block
        margin: -1px 4px 0 0
        vertical-align: middle
        cursor: pointer
        border: 0px solid #FFFFFF
        background-repeat: no-repeat
        background-position: center
        text-align: center
        line-height: 44px

        img
          position: relative
          top: -13px
          opacity: 0
          transition: all .3s ease
          width:10px




    &.color-1 + label span
      background-color: $color-1


    &.color-2 + label span
      background-color: $color-2


    &.color-3 + label span
      background-color: $color-3



    &:checked + label span img
      opacity: 1



</style>
