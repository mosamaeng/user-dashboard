<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
            </div>
        </div>
    </header>
  <div class="container">
    <div class="row">
        @foreach ($users as $user)
            <div class="col-md-4">
                <div class="user-card">
                <div class="user-card-header">
                    <div class="user-card-avatar" alt="User Avatar">
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }} avatar" onerror="this.onerror=null; this.parentElement.innerText = '{{ strtoupper(substr($user->name, 0, 1) ?? "A") }}';">
                    </div>
                    <div class="user-card-info">
                    <h4 class="user-card-name">{{ $user->name }}</h4>
                    <span class="user-card-occupation">{{ $user->occupation }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    
                    <div class="user-card-graph mr-3">
                        <canvas id="chart{{ $user->id }}"></canvas>
                    </div>
                    <div class="user-card-stats">
                        <div class="user-card-stat">{{ $user->impression_count }} <span>Impressions</span></div>
                        <div class="user-card-stat">{{ $user->conversion_count }} <span>Conversions</span></div>
                        <div class="user-card-stat">${{ $user->revenue }} <span>Revenue</span></div>
                    </div>
                </div>
                <script>
                    var conversionData = @json($user->conversion_per_day);
                    // var labels = conversionData.map(item => item.day);
                    var labels = ['Day-1', 'Day-2', 'Day-3', 'Day-4', 'Day-5'];
                    var ctx1 = document.getElementById('chart' + {{ $user->id }}).getContext('2d');
                    var userChart = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                        label: 'Conversion per day',
                        data: conversionData.map(item => item.count),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                        y: {
                            // beginAtZero: true
                        }
                        }
                    }
                    });
                </script>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</body>
</html>
