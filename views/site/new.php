<?php
    use richardfan\widget\JSRegister;
?>
<div id="app" class="container">
    <p>{{message}}</p>

    
</div>

<?php JSRegister::begin(); ?>
<script>    
    var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue!'
    }
    })
</script>

<?php JSRegister::end(); ?>