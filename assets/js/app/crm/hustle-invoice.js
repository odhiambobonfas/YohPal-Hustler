import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getFirestore, doc, getDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
import { firebaseConfig, invoiceConfig } from "../config/firebase-config.js";

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

const params = new URLSearchParams(window.location.search);
const jobId = params.get("job_id");

if (!jobId) {
    alert("Missing job_id parameter");
    document.querySelector('.invoice-container').innerHTML = '<h2>Error: Job ID is required</h2>';
    throw new Error("Missing job_id");
}

const $ = (id) => document.getElementById(id);

const { HOURLY_RATE, TRANSPORT_FEE, TAX_PERCENTAGE } = invoiceConfig;

async function loadInvoice() {
    try {
        const jobRef = doc(db, "hustle", "Jobs", "JobIds", jobId);
        const jobSnap = await getDoc(jobRef);

        if (!jobSnap.exists()) {
            alert("Job not found in database");
            document.querySelector('.invoice-container').innerHTML = '<h2>Error: Job not found</h2>';
            return;
        }

        const job = jobSnap.data();
        const start = job.startTime?.toDate() || new Date();
        const end = job.endTime?.toDate() || new Date();
        const durationMs = end - start;
        const hoursWorked = Math.max(1, Math.ceil(durationMs / (1000 * 60 * 60)));
        
        // Use actual job rates from Firebase, fallback to config
        const hourlyRate = job.hourlyRate || job.rate || HOURLY_RATE;
        const transportFee = job.transportFee || TRANSPORT_FEE;
        const taxPercentage = job.taxPercentage || TAX_PERCENTAGE;
        
        const jobFee = hoursWorked * hourlyRate;
        const taxFee = jobFee * taxPercentage;
        const totalFee = jobFee + transportFee + taxFee;

        $("jobTitle").textContent = job.name || "N/A";
        $("freelancerName").textContent = job.ownerName || "N/A";
        $("freelancerEmail").textContent = job.ownerEmail || "N/A";
        $("jobId").textContent = jobId;
        $("jobStatus").textContent = job.status || "pending";

        $("startTime").textContent = start.toLocaleString();
        $("endTime").textContent = end.toLocaleString();
        $("jobDate").textContent = start.toDateString();

        $("jobFee").textContent = `${hoursWorked} Hrs @ KES ${hourlyRate.toLocaleString()} Hourly\nKES ${jobFee.toLocaleString()}`;
        $("transportFee").textContent = `KES ${transportFee.toLocaleString()}`;
        $("taxFee").textContent = `KES ${taxFee.toLocaleString()}`;
        $("totalFee").textContent = `KES ${totalFee.toLocaleString()}`;

        $("jobDescription").textContent = job.description || "No description provided";

        $("jobFeeCheck").checked = true;
        $("transportFeeCheck").checked = true;
        $("taxFeeCheck").checked = true;

    } catch (err) {
        console.error("Invoice loading error:", err);
        alert("Failed to load invoice. Please check console for details.");
        document.querySelector('.invoice-container').innerHTML = '<h2>Error loading invoice</h2><p>' + err.message + '</p>';
    }
}

loadInvoice();