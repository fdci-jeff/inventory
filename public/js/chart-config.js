$(document).ready((function () {
    $.get("/sales-purchases/chart-data", (function (e) {

        var salesPurchasesCanvas = document.getElementById("salesPurchasesChart");

        var salesData = {
            labels: e.sales.original.days,
            datasets: [{
                label: "Sales",
                data: e.sales.original.data,
                backgroundColor: "#6366F1",
                borderColor: "#6366F1",
                borderWidth: 1
            }, {
                label: "Purchases",
                data: e.purchases.original.data,
                backgroundColor: "#A5B4FC",
                borderColor: "#A5B4FC",
                borderWidth: 1
            }]
        };

        var salesPurchasesChart = new Chart(salesPurchasesCanvas, {
            type: "bar",
            data: salesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }));

    $.get("/current-month/chart-data", (function (a) {
        var currentMonthCanvas = document.getElementById("currentMonthChart");

        var chartData = {
            labels: ["Sales", "Purchases", "Expenses"],
            datasets: [{
                data: [a.sales, a.purchases, a.expenses],
                backgroundColor: ["#F59E0B", "#0284C7", "#EF4444"],
                hoverBackgroundColor: ["#F59E0B", "#0284C7", "#EF4444"]
            }]
        };

        var currentMonthChart = new Chart(currentMonthCanvas, {
            type: "doughnut",
            data: chartData
        })
    }));

    $.get("/payment-flow/chart-data", (function (a) {
        var paymentCanvas = document.getElementById("paymentChart");
        
        var paymentData = {
            labels: a.months,
            datasets: [{
                label: "Payment Sent",
                data: a.payment_sent,
                fill: !1,
                borderColor: "#EA580C",
                tension: 0
            }, {
                label: "Payment Received",
                data: a.payment_received,
                fill: !1,
                borderColor: "#2563EB",
                tension: 0
            }]
        };

        var paymentChart =  new Chart(paymentCanvas, {
            type: "line",
            data: paymentData
        })
    }))
}));
