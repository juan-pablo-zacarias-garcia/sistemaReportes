<br />
<br />
<h4>Gráfica comparativa</h4>
<div class="col-12">
  <canvas id="myChart"></canvas>
</div>

<script src="{{asset('assets/js/chart.js')}}"></script>
<script>
var labels = {{ Illuminate\Support\Js::from($labels) }};
var datasets = <?php echo ($datasets); ?>;

  new Chart(document.getElementById('myChart'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets:datasets
    },
    options: {
      locale:'en-US',
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins:{
        
      }
      
    }
  });
</script>