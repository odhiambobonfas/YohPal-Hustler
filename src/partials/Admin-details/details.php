<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .content {
            width: 100%;
            max-width: 900px;
            margin: 6px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-height: 86vh;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .content::-webkit-scrollbar {
            display: none;
        }

        .details-header {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .details-header+p {
            font-size: 14px;
            color: #666;
            margin-top: 0;
            margin-bottom: 30px;
        }

        .details-title {
            font-size: 16px;
            font-weight: 600;
            margin: 30px 0 20px;
            text-transform: uppercase;
            color: #444;
        }

        .margin-top-40 {
            margin-top: 40px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px 20px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .field-group {
            display: flex;
            flex-direction: column;
        }

        .field-label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .field-label:after {
            content: "*";
            color: #e53935;
            margin-left: 4px;
        }

        .no-asterisk:after {
            content: none;
        }

        .field-value {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 12px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            background: #f9f9f9;
            color: #333;
            font-size: 14px;
            pointer-events: none;
        }

        .field-value.flex-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            background: transparent;
            border: none;
            padding: 0;
        }

        .tag {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .primary-tag {
            background: #e0f7fa;
        }

        .secondary-tag {
            background: #f3e5f5;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 12px;
            overflow: hidden;
            pointer-events: none;
            border: 2px solid #b8b6b6ff;
        }

        .bio-text {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 12px;
            background: #f9f9f9;
            color: #333;
            min-height: 120px;
            max-height: 200px;
            width: 100%;
            font-size: 14px;
            line-height: 1.5;
            resize: none;
            pointer-events: none;
            overflow-y: auto;
        }

        .document-link {
            display: inline-flex;
            align-items: center;
            color: #f00000;
            text-decoration: none;
            font-size: 14px;
            margin-top: 5px;
        }

        .document-link i {
            margin-right: 8px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-reject {
            background: #fff;
            border: 1px solid #d32f2f;
            color: #d32f2f;
        }

        .btn-accept {
            background: #f00000;
            border: 1px solid #f00000;
            color: white;
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="details-header">Account details</div>

        <div class="details-title">PROFILE</div>
        <div class="grid-container">
            <div class="field-group">
                <label class="field-label">Profile picture</label>
                <div class="profile-picture">
                    <span>No image</span>
                </div>
            </div>

            <div class="field-group">
                <label class="field-label">Name</label>
                <input type="text" class="field-value" value="David Kamau" readonly>
            </div>

            <div class="field-group">
                <label class="field-label">Email address</label>
                <input type="text" class="field-value" value="kamau@gmail.com" readonly>
            </div>

            <div class="field-group full-width">
                <label class="field-label">Profile bio</label>
                <textarea class="bio-text" readonly>I am a hustler and I am looking for a job</textarea>
            </div>
        </div>

        <div class="details-title margin-top-40">SELECTED SKILLS</div>
        <div class="grid-container">
            <div class="field-group full-width">
                <label class="field-label no-asterisk">Primary Skills</label>
                <div class="field-value flex-tags">
                    <span class="tag primary-tag">HTML</span>
                    <span class="tag primary-tag">CSS</span>
                    <span class="tag primary-tag">JavaScript</span>
                    <span class="tag primary-tag">React</span>
                </div>
            </div>

            <div class="field-group full-width">
                <label class="field-label no-asterisk">Secondary Skills</label>
                <div class="field-value flex-tags">
                    <span class="tag secondary-tag">PHP</span>
                    <span class="tag secondary-tag">SQL</span>
                    <span class="tag secondary-tag">Photoshop</span>
                    <span class="tag secondary-tag">UI/UX</span>
                </div>
            </div>
        </div>

        <div class="details-title margin-top-40">CONTACT INFORMATION</div>
        <div class="grid-container">
            <div class="field-group">
                <label class="field-label no-asterisk">Email</label>
                <input type="text" class="field-value" value="contact@lovable.dev" readonly>
            </div>

            <div class="field-group">
                <label class="field-label no-asterisk">Phone number</label>
                <input type="text" class="field-value" value="+254 7 123-45678" readonly>
            </div>

            <div class="field-group">
                <label class="field-label no-asterisk">Uploaded CV</label>
                <a href="#" class="document-link">
                    <i class="fas fa-file-pdf"></i> View CV (PDF, 245KB)
                </a>
            </div>

            <div class="field-group">
                <label class="field-label no-asterisk">Portfolio</label>
                <a href="#" class="document-link">
                    <i class="fas fa-link"></i> https://portfolio.lovable.dev
                </a>
            </div>
        </div>

        <div class="button-group">
            <button class="btn btn-reject">Reject</button>
            <button class="btn btn-accept">Accept</button>
        </div>
    </div>
</body>

</html>