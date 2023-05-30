$(document).ready((function () {
    var salesPurchasesChart = null;
    var currentMonthCanvas = document.getElementById("currentMonthChart");
    var currentMonthChart = null;
    var paymentCanvas = document.getElementById("paymentChart");
    

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
    var e = document.getElementById("currentMonthChart");
    $.get("/current-month/chart-data", (function (a) {

    
        currentMonthChart.destroy();
        

        currentMonthChart =  new Chart(currentMonthCanvas, {
            type: "doughnut",
            data: {
                labels: ["Sales", "Purchases", "Expenses"],
                datasets: [{
                    data: [a.sales, a.purchases, a.expenses],
                    backgroundColor: ["#F59E0B", "#0284C7", "#EF4444"],
                    hoverBackgroundColor: ["#F59E0B", "#0284C7", "#EF4444"]
                }]
            }
        })
    }));
    var t = document.getElementById("paymentChart");
    $.get("/payment-flow/chart-data", (function (a) {
        window.paymentChart =  new Chart(paymentCanvas, {
            type: "line",
            data: {
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
            }
        })
    }))
}));
