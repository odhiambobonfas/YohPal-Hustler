<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Invoice - YohPal Hustle</title>
    <style>
       

        .invoice-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-top: 0;
        }

        h2 {
            color: #f00000;
            margin-top: 25px;
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .job-info {
            flex: 1;
            min-width: 250px;
        }

        .job-status {
            background-color: #f39c12;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }

        .timeline {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 8px;
        }

        .timeline-label {
            font-weight: bold;
            min-width: 80px;
        }

        .payment-section {
            margin-top: 30px;
        }

        .payment-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        .payment-total {
            font-weight: bold;
            font-size: 1.1em;
            border-top: 2px solid #f00000;
            margin-top: 10px;
            padding-top: 10px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #f00000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c00000;
        }

        .checkbox {
            margin-right: 10px;
        }

        .job-description {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #f00000;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <h1>Job Summary</h1>

        <div class="job-header">
            <div class="job-info">
                <p><strong>Job Title:</strong> <span id="jobTitle">Loading...</span></p>
                <p><strong>Freelancer Name:</strong> <span id="freelancerName">Loading...</span></p>
                <p><strong>Email:</strong> <span id="freelancerEmail">Loading...</span></p>
                <p><strong>Job ID:</strong> <span id="jobId">Loading...</span></p>
            </div>
            <div>
                <p><strong>Job Status:</strong> <span class="job-status" id="jobStatus">Loading</span></p>
            </div>
        </div>

        <h2>WORK TIMELINE</h2>
        <div class="timeline">
            <div class="timeline-item">
                <span class="timeline-label">Start</span>
                <span id="startTime">--</span>
            </div>
            <div class="timeline-item">
                <span class="timeline-label">End</span>
                <span id="endTime">--</span>
            </div>
            <div class="timeline-item">
                <span class="timeline-label">Date</span>
                <span id="jobDate">--</span>
            </div>
        </div>

        <div class="payment-section">
            <h2>Payment Breakdown</h2>

            <div class="payment-item">
                <span><input type="checkbox" class="checkbox" id="jobFeeCheck" disabled> <span id="jobFeeLabel">Job Fee</span></span>
                <span id="jobFee" style="white-space: pre-line; text-align: right;">KES 0.00</span>
            </div>
            <div class="payment-item">
                <span><input type="checkbox" class="checkbox" id="transportFeeCheck" disabled> Transport Fee</span>
                <span id="transportFee">KES 0.00</span>
            </div>
            <div class="payment-item">
                <span><input type="checkbox" class="checkbox" id="taxFeeCheck" disabled> Tax Fee</span>
                <span id="taxFee">KES 0.00</span>
            </div>

            <div class="payment-item payment-total">
                <span><input type="checkbox" class="checkbox" disabled> Total Payment</span>
                <span id="totalFee">KES 0.00</span>
            </div>
        </div>

        <div class="job-description">
            <h3>JOB DESCRIPTION</h3>
            <p id="jobDescription">Loading job description...</p>
        </div>

        <div class="footer">
            <p><strong>YohPal Hustle</strong></p>
            <a href="#" class="btn" id="reportBtn">Report Issue</a>
            <a href="#" class="btn" id="downloadBtn" onclick="window.print(); return false;">Download Invoice</a>
        </div>
    </div>

    <script type="module" src="/assets/js/app/crm/hustle-invoice.js"></script>
</body>
</html>