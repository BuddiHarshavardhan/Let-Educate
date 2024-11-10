<?php
require_once('./constant/connect.php');
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['userId'] != 1) {
    header('location: login.php');
    exit();
}

// Handle deletion of a customer
if (isset($_GET['delete'])) {
    $customerId = $_GET['delete'];
    $stmt = $connect->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $customerId);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Customer deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting customer. Please try again.';
    }

    $stmt->close();
    header('location: manage-customer.php');
    exit();
}

// Fetch premium data and policy count
$premiumDataSql = "SELECT 
                        freelancer AS agent, 
                        CASE 
                            WHEN plan = 1 THEN 'Health Insurance'
                            WHEN plan = 2 THEN 'Life Insurance'
                            WHEN plan = 3 THEN 'Motor Insurance'
                            WHEN plan = 4 THEN 'Non Motor'
                            WHEN plan = 5 THEN 'SIPS'
                            WHEN plan = 6 THEN 'Loans'
                            WHEN plan = 7 THEN 'Credit'
                            ELSE 'Unknown'
                        END AS plan_name, 
                        COUNT(*) AS policy_count,
                        SUM(premium) AS total_premium 
                   FROM customers 
                   GROUP BY agent, plan_name";
$premiumDataResult = $connect->query($premiumDataSql);

$premiumData = [];
while ($row = $premiumDataResult->fetch_assoc()) {
    $premiumData[] = $row;
}

// Calculate total number of unique agents
$agents = array_unique(array_column($premiumData, 'agent'));
$totalAgents = count($agents);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include('./constant/layout/head.php');?>
    <?php include('./constant/layout/header.php');?>
    <?php include('./constant/layout/sidebar.php');?>

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Manage Customers</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Customers</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-title">
                            <h4>Total Premiums Generated by Each Agent per Plan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="premiumChart" width="300" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-title">
                            <h4>Number of Policies Handled by Each Agent per Plan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="policyChart" width="300" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Policy Details</h4>
                            <p>Total Agents: <?php echo $totalAgents; ?></p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <th>Plan Name</th>
                                        <th>Total Premium</th>
                                        <th>Policy Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($premiumData as $data): ?>
                                        <tr>
                                            <td><?php echo $data['agent']; ?></td>
                                            <td><?php echo $data['plan_name']; ?></td>
                                            <td><?php echo $data['total_premium']; ?></td>
                                            <td><?php echo $data['policy_count']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('./constant/layout/footer.php');?>
    </div>

    <script>
    // Helper function to format numbers in thousands (k) and lakhs (l)
    function formatNumber(value) {
        if (value >= 10000000) {
            return (value / 10000000).toFixed(2) + ' Cr'; // Crores
        } else if (value >= 100000) {
            return (value / 100000).toFixed(2) + ' L'; // Lakhs
        } else if (value >= 1000) {
            return (value / 1000).toFixed(2) + ' K'; // Thousands
        } else {
            return value;
        }
    }

    // Get the data from PHP
    const premiumData = <?php echo json_encode($premiumData); ?>;

    // Prepare the data for the premium chart (total premiums generated by each agent per plan)
    const agents = [...new Set(premiumData.map(item => item.agent))];
    const plans = [...new Set(premiumData.map(item => item.plan_name))];

    const premiumDatasets = plans.map(plan => {
        return {
            label: plan,
            data: agents.map(agent => {
                const record = premiumData.find(item => item.agent === agent && item.plan_name === plan);
                return record ? record.total_premium : 0;
            }),
            backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`,
            barThickness: 15 // Adjust bar thickness
        };
    });

    // Premium chart configuration
    const premiumConfig = {
        type: 'bar',
        data: {
            labels: agents,
            datasets: premiumDatasets
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatNumber(value); // Format y-axis values
                        }
                    },
                    title: {
                        display: true,
                        text: 'Premium Amount'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Agents'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    };

    // Render the premium chart
    const premiumChart = new Chart(
        document.getElementById('premiumChart'),
        premiumConfig
    );

    // Prepare the data for the policy chart (number of policies handled by each agent per plan)
    const policyDatasets = plans.map(plan => {
        return {
            label: plan,
            data: agents.map(agent => {
                const record = premiumData.find(item => item.agent === agent && item.plan_name === plan);
                return record ? record.policy_count : 0;
            }),
            backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`,
            barThickness: 15 // Adjust bar thickness
        };
    });

    // Policy chart configuration
    const policyConfig = {
        type: 'bar',
        data: {
            labels: agents,
            datasets: policyDatasets
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatNumber(value); // Format y-axis values
                        }
                    },
                    title: {
                        display: true,
                        text: 'Number of Policies'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Agents'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    };

    // Render the policy chart
    const policyChart = new Chart(
        document.getElementById('policyChart'),
        policyConfig
    );
</script>
</body>
</html>