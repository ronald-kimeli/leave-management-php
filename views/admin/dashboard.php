<?php
$employees = $data ? $data->employees : 0;
$apply_leave = $data ? $data->apply_leave : 0;
$leave_type = $data ? $data->leave_type : 0;
$departments = $data ? $data->departments : 0;
?>
<div class="container-fluid px-4">
  <h1 class="mt-4">ADMIN PANEL</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Admin Dashboard</li>
  </ol>
  <?php \app\messages\AlertMessage::display(); ?>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success text-white mb-4 ">
        <div class="card-body">Employees</div>
        <div class="card-footer">
          <h1><?= $employees ?></h1>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4 ">
        <div class="card-body">Departments</div>
        <div class="card-footer">
          <h1><?= $departments ?></h1>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-purple text-white mb-4 ">
        <div class="card-body">Applied leaves</div>
        <div class="card-footer">
          <h1><?= $apply_leave ?></h1>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-blue text-light mb-4 ">
        <div class="card-body">Leave Types</div>
        <div class="card-footer">
          <h1><?= $leave_type ?></h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card mb-4 ">
        <div class="card-header">Leave Types Distribution</div>
        <div class="card-body">
          <canvas id="leaveTypesChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-4 ">
        <div class="card-header">Employees and Departments</div>
        <div class="card-body">
          <canvas id="employeesDepartmentsChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var ctxLeaveTypes = document.getElementById('leaveTypesChart').getContext('2d');
  var leaveTypesChart = new Chart(ctxLeaveTypes, {
    type: 'pie',
    data: {
      labels: ['Sick Leave', 'Vacation Leave', 'Casual Leave', 'Other'],
      datasets: [{
        label: 'Leave Types',
        data: [12, 19, 3, 5],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          callbacks: {
            label: function (tooltipItem) {
              return tooltipItem.label + ': ' + tooltipItem.raw;
            }
          }
        }
      }
    }
  });

  // Employees and Departments Chart
  var ctxEmployeesDepartments = document.getElementById('employeesDepartmentsChart').getContext('2d');
  var employeesDepartmentsChart = new Chart(ctxEmployeesDepartments, {
    type: 'bar',
    data: {
      labels: ['Employees', 'Departments'],
      datasets: [{
        label: 'Count',
        data: [<?= $employees ?>, <?= $departments ?>],
        backgroundColor: [
          'rgba(255, 159, 64, 0.2)',
          'rgba(153, 102, 255, 0.2)'
        ],
        borderColor: [
          'rgba(255, 159, 64, 1)',
          'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          callbacks: {
            label: function (tooltipItem) {
              return tooltipItem.label + ': ' + tooltipItem.raw;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php require __DIR__ . "/components/footer.php"; ?>