<script>
    $(document).ready(function() {

        // DEFAULT BULAN INI
        setQuickRange('month');

        // QUICK FILTER CLICK
        $('.quick-filter').on('click', function() {

            // remove active
            $('.quick-filter')
                .removeClass('btn-primary')
                .addClass('btn-light');

            // active current button
            $(this)
                .removeClass('btn-light')
                .addClass('btn-primary');

            let range = $(this).data('range');

            setQuickRange(range);

            loadReport();
        });

    });


    // ===========================
    // SET QUICK RANGE
    // ===========================

    function setQuickRange(type) {
        const today = new Date();

        let startDate;
        let endDate = new Date();

        // TODAY
        if (type === 'today') {

            startDate = new Date();

        }

        // 7 DAYS
        else if (type === '7days') {

            startDate = new Date();

            startDate.setDate(
                today.getDate() - 6
            );

        }

        // 30 DAYS
        else if (type === '30days') {

            startDate = new Date();

            startDate.setDate(
                today.getDate() - 29
            );

        }

        // THIS MONTH
        else if (type === 'month') {

            startDate = new Date(
                today.getFullYear(),
                today.getMonth(),
                1
            );

        }

        // LAST MONTH
        else if (type === 'lastmonth') {

            startDate = new Date(
                today.getFullYear(),
                today.getMonth() - 1,
                1
            );

            endDate = new Date(
                today.getFullYear(),
                today.getMonth(),
                0
            );

        }

        // SET INPUT DATE
        $('#startDate').val(
            formatDate(startDate)
        );

        $('#endDate').val(
            formatDate(endDate)
        );
    }


    // ===========================
    // FORMAT DATE YYYY-MM-DD
    // ===========================

    function formatDate(date) {
        let month = '' + (date.getMonth() + 1);

        let day = '' + date.getDate();

        let year = date.getFullYear();

        if (month.length < 2) {
            month = '0' + month;
        }

        if (day.length < 2) {
            day = '0' + day;
        }

        return [
            year,
            month,
            day
        ].join('-');
    }
</script>
<script>
    const today = new Date();

    // tanggal awal bulan
    const firstDay = new Date(
        today.getFullYear(),
        today.getMonth(),
        1
    );



    $('#startDate').val(
        formatDate(firstDay)
    );

    $('#endDate').val(
        formatDate(today)
    );


    loadReport();

    $('#filterBtn').on('click', function() {
        loadReport();
    });


    function loadReport() {
        resetCard();
        $.ajax({
            url: "{{ url('report/lead/data') }}",
            data: {
                search: $('#search').val(),
                start_date: $('#startDate').val(),
                end_date: $('#endDate').val(),
                status: $('#status').val(),
                branch_id: $('#branchId').val(),
            },
            success: function(response) {
                console.log(response);
                $("#card-total").text(response.summary.total);
                $("#card-new").text(response.summary.new_leads);
                $("#card-visit").text(response.summary.visit);
                $("#card-confirm").text(response.summary.confirm);

                renderLeadsChart(response.chart);
                renderStatusChart(response.status_chart);
                renderSourceChart(response.source_chart);
                renderTopAdmins(response.top_admins);
                renderRecentLeads(response.recent_leads);


            }
        });
    }

    function resetCard() {
        $("#card-total").text('...');
        $("#card-new").text('...');
        $("#card-visit").text('...');
        $("#card-confirm").text('...');
    }
</script>

<script>
    let leadsChart;


    // ========================
    // RENDER CHART
    // ========================

    function renderLeadsChart(chartData) {

        if (chartData.data.length === 0) {

            $('#leadsChart').html(`
        <div class="text-center py-5 text-muted">
            Tidak ada data
        </div>
    `);

            return;
        }
        // destroy old chart
        if (leadsChart) {
            leadsChart.destroy();
        }

        let options = {

            chart: {
                type: 'area',
                height: 250,
                toolbar: {
                    show: false
                }
            },

            series: [{
                name: 'Leads',
                data: chartData.data
            }],

            xaxis: {
                categories: chartData.labels
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            dataLabels: {
                enabled: false
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                }
            },

            grid: {
                borderColor: '#f1f1f1'
            },

            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + ' leads';
                    }
                }
            }

        };

        leadsChart = new ApexCharts(
            document.querySelector("#leadsChart"),
            options
        );

        leadsChart.render();
    }
</script>

<script>
    let statusChart;

    function renderStatusChart(chartData) {
        if (statusChart) {
            statusChart.destroy();
        }

        let options = {

            chart: {
                type: 'donut',
                height: 250
            },

            series: chartData.data,

            labels: chartData.labels,

            legend: {
                position: 'bottom'
            },

            dataLabels: {
                enabled: false
            }

        };

        statusChart = new ApexCharts(
            document.querySelector("#statusChart"),
            options
        );

        statusChart.render();
    }
</script>
<script>
    let sourceChart;

    function renderSourceChart(chartData) {
        if (sourceChart) {
            sourceChart.destroy();
        }

        let options = {

            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },

            series: [{
                name: 'Leads',
                data: chartData.data
            }],

            xaxis: {
                categories: chartData.labels
            },

            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true
                }
            },

            dataLabels: {
                enabled: false
            }

        };

        sourceChart = new ApexCharts(
            document.querySelector("#sourceChart"),
            options
        );

        sourceChart.render();
    }

    function renderTopAdmins(admins) {
        let html = '';

        admins.forEach(function(admin) {

            html += `

            <div class="d-flex
                        justify-content-between
                        align-items-center
                        mb-3">

                <div>

                    <h6 class="mb-0">
                        ${admin.created_by.name}
                    </h6>

                    <small class="text-muted">
                        Leads handled
                    </small>

                </div>

                <span class="badge bg-primary">
                    ${admin.total}
                </span>

            </div>

        `;
        });

        $('#topAdmins').html(html);
    }

    function renderRecentLeads(leads) {
        let html = '';
        leads.forEach(function(lead) {
            html += `
            <tr>
                <td>
                    ${lead.fullname}
                </td>
                <td>
                    <span class="badge bg-primary">
                        ${lead.status}
                    </span>
                </td>
                <td>
                    ${lead.created_by
                        ? lead.created_by.name
                        : '-'}
                </td>
                <td>
                    ${formatTgl(lead.created_at)}
                </td>
            </tr>
        `;
        });

        $('#recentLeadsTable').html(html);
    }
</script>
