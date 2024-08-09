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
  <?php \app\messages\AlertMessage::display();?>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success text-white mb-4">
        <div class="card-body">Employees</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
          <?= '<h1>' . $employees . '</h1>'?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4">
        <div class="card-body">Departments</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
          <?= '<h1>' . $departments . '</h1>'?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-purple text-white mb-4">
        <div class="card-body">Applied leaves</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
          <?= '<h1>' . $apply_leave . '</h1>'?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-blue text-light mb-4">
        <div class="card-body">Leave Types</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
          <?= '<h1>' .$leave_type . '</h1>'?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/components/footer.php";?>

    <!-- <div class="container-fluid px-4">
        <h4 class="mt-4">Dashboard</h4>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Total Employees</div>
                    <div class="card-footer d-flex align-items-center justify-content-start">
                        <h1>
                            <'<h1>' . (isset($data->employees) ? count($data->employees) : 0) . '</h1>'?>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <!-- <script>
        // Example data from PHP (replace with dynamic data from your backend)
        const employees = < json_encode($data->employees); ?>;

        // Helper function to count occurrences
        function countOccurrences(arr, key) {
            return arr.reduce((acc, item) => {
                const value = item[key];
                acc[value] = (acc[value] || 0) + 1;
                return acc;
            }, {});
        }

        // Prepare data for radar chart
        const genderCounts = countOccurrences(employees, 'gender');
        const statusCounts = countOccurrences(employees, 'status');
        const departmentCounts = countOccurrences(employees, 'department');
        const roleCounts = countOccurrences(employees, 'role');

        // Convert data to array format suitable for radar chart
        const labels = [
            'Gender (Male)', 'Gender (Female)', 
            'Status (Active)', 'Status (Disabled)', 
            'Department (Finances)', 'Department (Marketing)', 'Department (ITs)', 'Department (Operations)', 
            'Role (Admin)', 'Role (Employee)', 'Role (Manager)'
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Employee Distribution',
                data: [
                    genderCounts['Male'] || 0,
                    genderCounts['Female'] || 0,
                    statusCounts['active'] || 0,
                    statusCounts['disabled'] || 0,
                    departmentCounts['Finances'] || 0,
                    departmentCounts['Marketing'] || 0,
                    departmentCounts['ITs'] || 0,
                    departmentCounts['Operations'] || 0,
                    roleCounts['admin'] || 0,
                    roleCounts['employee'] || 0,
                    roleCounts['manager'] || 0
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Radar Chart
        new Chart(document.getElementById('radarChart'), {
            type: 'radar',
            data: data,
            options: {
                responsive: true,
                scales: {
                    r: {
                        angleLines: {
                            display: false
                        },
                        suggestedMin: 0,
                        suggestedMax: Math.max(...data.datasets[0].data) + 10
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script> -->

