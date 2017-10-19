<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@2.4.4/dist/vue.js"></script>

<script>
    /**
     * Number.prototype.format(n, x, s, c)
     * 
     * @param integer n: length of decimal
     * @param integer x: length of whole part
     * @param mixed   s: sections delimiter
     * @param mixed   c: decimal delimiter
     */
     Number.prototype.format = function(n, x, s, c) {
      var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
      num = this.toFixed(Math.max(0, ~~n));

      return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
  };
</script>