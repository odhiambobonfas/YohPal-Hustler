<?php

namespace Yohpal\Models;

use GuzzleHttp\Client;

/**
 * Model class acts as the Base class model. A bridge to other models if need be. 
 * 
 * A cleaner approach to modelling structure.
 * Right here with YohPal forever!
 */
class Model
{

    protected $client;

    protected $endpoint;

    protected $auth_token;

    public function __construct()
    {
        $this->client = new Client([
            'debug' => env('API_DEBUG', false)
        ]);
    }
    /**
     * Returns a raw array of hustle categories.
     *
     * @return array<int, array<string, mixed>> List of categories with 'id' and 'name'
     */
    public static function hustleCategories(): array
    {
        $mixedCategories = self::hustleMixedCategories(); 

        $count = 1;
        $superCategories = [];
        foreach ($mixedCategories as $row) {
            $category = $row['category'];
            if (!isset($superCategories[$category])) {
                $superCategories[$category] = [
                    'id' => $count++,
                    'name' => $category,
                    'icon' => $row['category_icon']
                ];
            }
        }

        return $superCategories;
    }

    /**
     * Returns a raw array of hustle categories alongside sub categories and icons accessors.
     *
     * @return array<int, array<string, mixed>> List of categories with 'id' and 'name'
     */
    public static function hustleMixedCategories(): array
    {
        $mixedCategories = [
            "Business Operations & Management" => [
                "Human Resources (HR) & People Management" => [
                    "HR Assistant",
                    "HR Coordinator",
                    "HR Director",
                    "HR Generalist",
                    "HR Manager",
                    "Chief Human Resources Officer",
                    "Employee Relations Manager",
                    "Payroll Specialist",
                    "Recruitment Consultant",
                    "Recruitment Manager",
                    "Diversity, Equity, and Inclusion (DEI) Officer/Specialist",
                    "Compensation Specialist",
                    "Benefits Administrator"
                ],
                "Administrative & Clerical Support" => [
                    "Clerical or Administrative Assistant",
                    "Company Secretary",
                    "Legal Secretary",
                    "Medical Secretary",
                    "Personal Assistant",
                    "Receptionist",
                    "Office Manager"
                ],
                "Operations & Project Management" => [
                    "Operations Manager",
                    "Program Manager",
                    "Project Manager",
                    "Scrum Master",
                    "Facilities Management",
                    "Risk Manager",
                    "Estimator"
                ],
                "Marketing & Communications" => [
                    "Market Research Interviewer",
                    "Marketing Manager",
                    "Music Promotion Manager",
                    "PR & Communications Officer"
                ],
                "Customer Service & Sales" => [
                    "Customer Service Administrator",
                    "Sales Manager"
                ],
                "Procurement & Supply Chain" => [
                    "Procurement Administrator",
                    "Procurement Manager"
                ]
            ],
            "Finance & Accounting Professions" => [
                "Banking & Retail Finance" => [
                    "Bank or Building Society Customer Adviser",
                    "Bank or Building Society Manager",
                    "Bank Teller",
                    "Branch Manager",
                    "Loan Officer",
                    "Personal Banker"
                ],
                "General Management & Consulting" => [
                    "Management Consultant",
                    "Business Adviser"
                ],
                "Investment & Capital Markets" => [
                    "Debt Capital Markets (DCM) Analyst/Associate",
                    "Equity Capital Markets (ECM) Analyst/Associate",
                    "Investment Analyst (Buy - Side)",
                    "Investment Banker",
                    "Investment Operations Administrator",
                    "Investor Relations Specialist",
                    "Mutual Fund Manager",
                    "Portfolio Manager",
                    "Private Equity Assistant",
                    "Venture Capital Analyst/Associate"
                ],
                "Accounting & Auditing" => [
                    "Account Assistant",
                    "Accountant",
                    "Tax Accountant",
                    "Auditor",
                    "Financial Examiner",
                    "Insurance Account Manager"
                ],
                "Insurance & Risk Management" => [
                    "Actuary",
                    "Claim Adjuster",
                    "Insurance Broker",
                    "Insurance Claim Handler",
                    "Insurance Risk Surveyor",
                    "Insurance Underwriter"
                ],
                "Financial Advisory & Planning" => [
                    "Financial Analyst (Corporate)"
                ],
                "Corporate Finance & Treasury" => [
                    "Chief Financial Officer",
                    "Treasury Analyst/Manager"
                ],
                "Compliance" => [
                    "Compliance Officer"
                ]
            ],
            "Arts, Entertainment & Production" => [
                "Performance & Talent" => [
                    "Actor",
                    "Stunt Performer"
                ],
                "Technical Production & Operations" => [
                    "Assistant Technical Director",
                    "Technical Director",
                    "Event Technician",
                    "Theatre Technician",
                    "Master Electrician",
                    "Lighting Manager",
                    "Pyro Technician",
                    "Rigging & Automation",
                    "Sound Manager",
                    "Special Effect Specialist"
                ],
                "Set, Costume & Wardrobe" => [
                    "Scenic Artist",
                    "Set Designer",
                    "Costume Technician",
                    "Dresser",
                    "Wardrobe Assistant - Film, TV or Theatre"
                ],
                "Stage & Crew Management" => [
                    "Crew Member",
                    "Stage Manager",
                    "Stagehand"
                ],
                "Venue Management" => [
                    "Venue Manager"
                ]
            ],
            "Alternative & Holistic Health Practices" => [
                "Bodywork & Manual Therapies" => [
                    "Chiropractor",
                    "Craniosacral Therapist",
                    "Massage Therapist",
                    "Osteopath",
                    "Rolfing Structural Integrator",
                    "Therapeutic Touch Practitioner",
                    "Alexander Technique Teacher",
                    "Feldenkrais Method Practitioner"
                ],
                "Traditional & Energy-Based Systems" => [
                    "Acupuncturist",
                    "Traditional Chinese Medicine (TCM) Practitioner",
                    "Ayurvedic Practitioner",
                    "Energy Healer",
                    "Reiki Practitioner"
                ],
                "Mind-Body & Behavioral Practices" => [
                    "Biofeedback Practitioner",
                    "Guided Imagery Practitioner",
                    "Hypnotherapist"
                ],
                "Nutritional & Botanical Therapies" => [
                    "Aromatherapist",
                    "Dietary Supplement Specialist",
                    "Herbalist",
                    "Holistic Nutritionist"
                ],
                "Integrative & Naturopathic Medicine" => [
                    "Functional Medicine Practitioner",
                    "Homeopath",
                    "Integrative Medicine Physician",
                    "Integrative Nurse Practitioner",
                    "Naturopath"
                ]
            ],
            "Legal & Judicial Support" => [
                "Specialized Legal Roles" => [
                    "Arbitrator/Mediator",
                    "Intellectual Property Administrator"
                ],
                "Legal Support & Paralegal" => [
                    "Document Controller",
                    "eDiscovery Specialist",
                    "Law Clerk",
                    "Legal Billing Specialist"
                ],
                "Court & Administrative Support" => [
                    "Administrative Assistant or Officer-Courts",
                    "Clerk of Court"
                ]
            ],
            "Advisory, Consulting & Coaching" => [
                "Financial Advisory & Planning" => [
                    "Capital Markets Advisor",
                    "Corporate Finance Advisor",
                    "Estate Planning Advisor",
                    "Insurance Advisor",
                    "Investment Advisor",
                    "M&A Advisor (Mergers & Acquisitions)",
                    "Retirement Planning Advisor",
                    "Financial Advisor/Planner",
                    "Wealth Advisor/Manager"
                ],
                "Business & Strategy Consulting" => [
                    "Franchise Advisor",
                    "Growth Strategy Advisor",
                    "Innovation Advisor",
                    "Market Entry Advisor",
                    "Organizational Development Consultant",
                    "Small Business Advisor",
                    "Startup Advisor",
                    "Sales & Marketing Advisor",
                    "Business Advisor/Consultant"
                ],
                "Human Resources & Talent Development" => [
                    "Careers Adviser",
                    "Compensation & Benefits Consultant",
                    "Talent Management Advisor"
                ],
                "Personal & Well-being Coaching/Consulting" => [
                    "Advice Worker",
                    "Customer Experience (CX) Advisor",
                    "Financial Coach (personal)",
                    "Image Consultant",
                    "Life Coach",
                    "Personal Stylist",
                    "Wellness Coach"
                ]
            ],
            "Legal Profession & Judiciary" => [
                "Lawyers & Attorneys (General Practice & Specializations)" => [
                    "Advocate",
                    "Corporate Counsel / In-House Counsel",
                    "Criminal Defense Lawyer",
                    "Employment Lawyer",
                    "Environmental Attorney",
                    "Family Law Attorney",
                    "Human Rights Lawyer",
                    "Immigration Lawyer",
                    "International Law Practitioner",
                    "Legal Aid Lawyer",
                    "Legal Counsel (Government/Non-Profit)",
                    "Legislative Counsel",
                    "Patent Attorney",
                    "Public Defender",
                    "Real Estate Attorney",
                    "Solicitor",
                    "Tax Attorney",
                    "Trademark Attorney"
                ],
                "Judiciary & Court Officials" => [
                    "District Attorney (DA) / Prosecutor",
                    "Judge or Sheriff",
                    "Procurator Fiscal",
                    "Military Lawyer / Judge Advocate General (JAG)"
                ],
                "Legal Research & Academia" => [
                    "Academic Lawyer / Law Professor",
                    "Legal Researcher",
                    "Law Librarian"
                ]
            ],
            "Agriculture" => [
                "Farm & Land Management" => [
                    "Agribusiness Manager",
                    "Dairy Farm Manager",
                    "Estate or Land Manager",
                    "Farm Manager",
                    "Farm Worker / Laborer",
                    "Farm Worker or Stockperson",
                    "Poultry Farm Manager",
                    "Ranch Manager"
                ],
                "Agricultural Science & Research" => [
                    "Agricultural Economist",
                    "Agricultural Engineer",
                    "Agricultural Researcher",
                    "Agricultural Scientist",
                    "Agronomist",
                    "Animal Scientist / Livestock Specialist",
                    "Aquaculturist",
                    "Plant Breeder / Geneticist",
                    "Soil Scientist"
                ],
                "Advisory, Extension & Consulting (Agriculture-Specific)" => [
                    "Agricultural Extension Officer / Advisor",
                    "Crop Consultant",
                    "Organic Farming Consultant",
                    "Precision Agriculture Specialist"
                ],
                "Specialized Agricultural Roles" => [
                    "Agricultural Policy Analyst",
                    "Irrigation Specialist",
                    "Seed Production Specialist",
                    "Supply Chain Manager (Agriculture)",
                    "Sustainable Agriculture Specialist"
                ],
                "Agricultural Business & Marketing" => [
                    "Agricultural Banker / Lender",
                    "Agricultural Consultant",
                    "Agricultural Journalist / Communicator",
                    "Agricultural Marketing Specialist",
                    "Agricultural Sales Representative"
                ],
                "Forestry & Related Management" => [
                    "Forestry Manager / Forester",
                    "Horticulturist"
                ]
            ],
            "Engineering & Technical Sciences" => [
                "Aerospace & Aeronautical Engineering" => [
                    "Aeronautical Engineering",
                    "Aeronautical Engineer (focus on aircraft)",
                    "Aircraft Designer",
                    "Aircraft Maintenance Engineer",
                    "Aircraft Technician",
                    "Airframe & Powerplant Mechanic",
                    "Maintenance Engineer / Technician (aircraft maintenance)",
                    "Propulsion Engineer (focuses on engines)",
                    "Stress Engineer (analyzes stress on aircraft components)",
                    "Avionics Engineer",
                    "Draftsperson (aerospace)",
                    "Aerospace Project Manager (aerospace programs)",
                    "Compliance Officer (aerospace regulations)"
                ],
                "Civil & Structural Engineering" => [
                    "Civil Engineer",
                    "Civil Engineer (Civil focus)",
                    "Structural Engineer",
                    "Construction Engineer",
                    "Geotechnical Engineer",
                    "Water Resources Engineer",
                    "Land Surveyor",
                    "Quantity Surveyor"
                ],
                "Electrical & Electronics Engineering" => [
                    "Electrical Engineer",
                    "Electronics Engineer",
                    "Telecommunications Engineer",
                    "Broadcast Engineer"
                ],
                "Mechanical & Industrial Engineering" => [
                    "Mechanical Engineer",
                    "Industrial Engineer",
                    "Manufacturing Engineer",
                    "Maintenance Engineer",
                    "Facilities Engineer",
                    "HVAC Engineer",
                    "Quality Control Engineer",
                    "Quality Control Technician",
                    "Quality Engineer",
                    "Materials Engineer",
                    "Welding Engineer"
                ],
                "Chemical & Process Engineering" => [
                    "Chemical Engineer",
                    "Chemical Process Engineer",
                    "Environmental Engineer (Chemical process focus)",
                    "Petroleum Engineer",
                    "Process Engineer"
                ],
                "Computer & Software Engineering/IT" => [
                    "Software Engineer (often overlaps with Computer Science)",
                    "Cybersecurity Engineer",
                    "Network Engineer",
                    "Information Technology Engineer",
                    "IT Administrator",
                    "Database Administrator",
                    "Web Developer"
                ],
                "Environmental Engineering & Science (Broader Scope)" => [
                    "Environmental Engineer",
                    "Air Quality Engineer",
                    "Environmental Engineer (Civil Engineering background)",
                    "Environmental Engineer (Environmental process focus)",
                    "Environmental Health and Safety Officer",
                    "Environmental Consultant",
                    "Environmental Data Analyst",
                    "Environmental Project Manager",
                    "Environmental Scientist",
                    "Hydrologist (Environmental focus)",
                    "Marine Environmental Engineer",
                    "Mining Environmental Engineer",
                    "Noise and Vibration Engineer (aircraft acoustics)",
                    "Permitting Specialist (Environmental focus)",
                    "Pollution Control Engineer",
                    "Remediation Specialist",
                    "Waste Management Specialist/Engineer",
                    "Water Quality Engineer",
                    "Water Treatment Engineer"
                ],
                "Biomedical & Healthcare Engineering" => [
                    "Biomedical Engineer",
                    "Clinical Engineer",
                    "Rehabilitation Engineer"
                ],
                "Geoscience & Mining Engineering" => [
                    "Mining Engineer",
                    "Geological Engineer",
                    "Geologist (Environmental focus)",
                    "Geophysicist (hydrogeological applications)",
                    "Mineral Processing Engineer",
                    "Metallurgical Engineer"
                ],
                "Specialized Engineering & Research Roles" => [
                    "Automotive Engineer",
                    "Cement Production Engineer",
                    "Computer Aided Design (CAD) Engineer",
                    "Computational Fluid Dynamics (CFD) Engineer",
                    "Design Engineer",
                    "Energy Engineer",
                    "Exploration Geologist",
                    "Operations Engineer",
                    "Photonic Engineer",
                    "Predictive Analytics Engineer",
                    "Quality Assurance Engineer",
                    "Reliability Engineer",
                    "Research and Development (R&D) Engineer",
                    "Robotics Engineer",
                    "Stress Engineer",
                    "Test Engineer",
                    "Traffic Engineer",
                    "Urban Planning Engineer",
                    "Value Engineer",
                    "Marine Engineer",
                    "Marine Engineer (Mechanical)",
                    "Marine Design Engineer",
                    "Ocean Engineer",
                    "Offshore Engineer",
                    "Quarry Engineer",
                    "Tunnel Engineer",
                    "Underground Engineer"
                ]
            ],
            "Environmental Science, Sustainability & Conservation" => [
                "Environmental Management & Policy" => [
                    "Community Waste Officer",
                    "Environment and Compliance Adviser",
                    "Environment Manager",
                    "Environmental Policy Analyst",
                    "Environmental Planner",
                    "ESG (Environment, Social and Governance) Analyst",
                    "Hazardous Waste Manager",
                    "Health and Safety Inspector",
                    "Nature Conservationist",
                    "Park Ranger (Environmental focus)",
                    "Sustainability Coordinator/Manager",
                    "Waste Management Specialist/Engineer"
                ],
                "Environmental Science & Research" => [
                    "Conservation Scientist",
                    "Ecologist",
                    "Geologist (Environmental focus)",
                    "Hydrologist",
                    "Wildlife Biologist"
                ],
                "Environmental Engineering & Technical Specialists" => [
                    "Air Quality Specialist/Engineer",
                    "GIS Specialist (Environmental applications)",
                    "Pollution Control Engineer",
                    "Remediation Specialist",
                    "Renewable Energy Engineer",
                    "Water Quality Specialist/Engineer",
                    "Pest Control Technician"
                ],
                "Environmental Advisory & Education" => [
                    "Air Quality Consultant",
                    "Climate Change Analyst/Consultant",
                    "Environment and Compliance Adviser",
                    "Environmental Educator",
                    "Environmental Health Officer",
                    "Environmental Consultant",
                    "Renewable Energy Consultant"
                ],
                "Forestry & Related" => [
                    "Gamekeeper"
                ],
                "Permitting & Regulatory" => [
                    "Permitting Specialist"
                ]
            ],
            "Aviation & Aerospace Operations" => [
                "Flight Operations & Piloting" => [
                    "Drone Pilot",
                    "Flight Dispatcher",
                    "Helicopter Pilot",
                    "Pilot"
                ],
                "Cabin & Passenger Services" => [
                    "Air Cabin Crew",
                    "Airline or Airport Passenger Service Assistant"
                ],
                "Ground Operations & Support" => [
                    "Ramp Agent",
                    "Aviation Security Manager"
                ],
                "Aviation Maintenance & Technical" => [
                    "Aircraft Maintenance Instructor",
                    "Simulator Technician"
                ],
                "Aviation Education & Analysis" => [
                    "Aviation Educator",
                    "Flight Instructor",
                    "Aviation Analyst"
                ]
            ],
            "Ambulance Services and Emergency Services" => [
                "Ambulance & Paramedical Services" => [
                    "Ambulance Care Assistant",
                    "Ambulance Driver",
                    "Ambulance Fleet Manager",
                    "Ambulance Media Dispatcher",
                    "Ambulance Services",
                    "Ambulance Technician",
                    "Clinical Lead Paramedic",
                    "Emergency Medical Technician (EMT)",
                    "Emergency Care Assistant",
                    "Paramedic"
                ],
                "Emergency Communications & Coordination" => [
                    "Emergency Call Handlers",
                    "Emergency Communications Operator",
                    "Emergency Planner"
                ],
                "Fire & Hazardous Materials Response" => [
                    "Firefighter",
                    "Wildland Firefighter",
                    "Hazardous Materials (HAZMAT) Technician"
                ],
                "Law Enforcement & Public Safety" => [
                    "Public Safety Officer",
                    "Forensic Investigator"
                ],
                "Rescue & Maritime Safety" => [
                    "Coastguard",
                    "Marine Rescue Specialist / Coast Guard"
                ],
                "Emergency Medical Personnel (Hospital-based)" => [
                    "Emergency Physician",
                    "Emergency Room (ER) Nurse",
                    "Trauma Surgeon"
                ],
                "Training & Development (within Emergency Services)" => [
                    "Training Officer"
                ]
            ],
            "Information Technology (IT) & Software Development" => [
                "Software Development & Engineering" => [
                    "API Developer",
                    "Application Developer",
                    "Back-End Architect",
                    "Blockchain Developer",
                    "Full-Stack Developer",
                    "Mobile Web Developer",
                    "Software Tester",
                    "Web Developer"
                ],
                "Specialized IT & Emerging Technologies" => [
                    "Artificial Intelligence Specialist/Engineer",
                    "DevOps Engineer",
                    "Performance Optimization Engineer",
                    "Virtual Reality/Augmented Reality Developer"
                ],
                "Data & Infrastructure" => [
                    "Database Administrator"
                ],
                "Web Design & Management" => [
                    "Digital Media Designer",
                    "Front-End Developer",
                    "Web Designer",
                    "Webmaster"
                ],
                "Gaming Industry" => [
                    "Animator",
                    "Game Designer",
                    "Game Programmer",
                    "Game Tester"
                ],
                "User Experience (UX) & Design" => [
                    "User Experience (UX) Designer"
                ]
            ],
            "Healthcare & Medical Support Services" => [
                "Clinical Diagnostics & Laboratory" => [
                    "Anatomical Pathology Technologist",
                    "Biomedical Scientist",
                    "Cytotechnologist",
                    "Hematologist",
                    "Histotechnologist",
                    "Nuclear Medicine Technologist",
                    "Pathologist Assistant",
                    "Radiologic Technologist",
                    "Sonographer"
                ],
                "Therapeutic & Rehabilitation Services" => [
                    "Audiologist",
                    "Orthotist/Prosthetist",
                    "Prosthetic or Orthotic Support Worker",
                    "Rehabilitation Engineering Technician",
                    "Respiratory Physiologist"
                ],
                "Specialized Clinical Support" => [
                    "Cardiac Physiology",
                    "Clinical Perfusionist",
                    "Decontamination Technician",
                    "Operating Department Practitioner",
                    "Theatre Support Worker"
                ],
                "Clinical Research & Technology" => [
                    "Clinical and Biomedical Engineer",
                    "Clinical Research Coordinator",
                    "Clinical Technologist (Clinical Engineering)"
                ]
            ],
            "Animal Care, Welfare & Science" => [
                "Direct Animal Care & Support" => [
                    "Animal Care Assistant",
                    "Animal Technician",
                    "Stablehand or Groom",
                    "Veterinary Nurse"
                ],
                "Animal Health & Veterinary Medicine" => [
                    "Farrier",
                    "Veterinary Surgeon"
                ],
                "Animal Training & Behavior" => [
                    "Assistance Dog Trainer",
                    "Dog Groomer",
                    "Dog Handler",
                    "Riding Instructor"
                ],
                "Animal Welfare & Rescue" => [
                    "Scottish SPCA Animal Rescue Officer",
                    "Scottish SPCA Inspector"
                ],
                "Zoo & Wildlife Science" => [
                    "Zookeeper"
                ]
            ],
            "Art, Design & Visual Media" => [
                "Digital & 3D Art/Animation" => [
                    "Animator",
                    "Character Artist",
                    "Environment Artist",
                    "Generative Artist",
                    "Sculptor - 3D",
                    "Texture Artist",
                    "Visual Effect Artist"
                ],
                "Graphic & Illustrative Design" => [
                    "Graphic Designer",
                    "Illustrator",
                    "Scientific or Technical Illustrator",
                    "Signwriter",
                    "Storyboard Artist"
                ],
                "Fine Art & Traditional Media" => [
                    "Fine Artist"
                ],
                "Immersive Media & Pre-Production" => [
                    "Previsualisation Artist"
                ]
            ],
            "Horticulture, Landscaping, and Botanical Science" => [
                "Horticultural Science & Research" => [
                    "Botanist",
                    "Crop Specialist",
                    "Floriculturist",
                    "Horticultural Scientist",
                    "Olericulturist",
                    "Plant Propagator"
                ],
                "Landscape & Grounds Management" => [
                    "Arborist",
                    "Gardener",
                    "Greenhouse Manager",
                    "Groundsperson",
                    "Hardscape Installer",
                    "Irrigation Technician",
                    "Landscape Architect",
                    "Landscaper"
                ],
                "Horticultural Consulting & Therapy" => [
                    "Horticultural Consultant",
                    "Horticultural Therapist"
                ]
            ],
            "Heritage, Archives & Museum Professions" => [
                "Archival & Collections Management" => [
                    "Collections Manager / Registrar",
                    "Librarian",
                    "Oral Historian"
                ],
                "Conservation & Restoration" => [
                    "Conservator (Objects, Paintings, Textiles, Paper, Digital)",
                    "Restoration Specialist (Art, Buildings, Artifacts)"
                ],
                "Museum & Exhibition Roles" => [
                    "Curator (Museum, Gallery, Collections)",
                    "Exhibition Designer / Developer",
                    "Museum Assistant or Visitor Assistant",
                    "Museum Educator / Public Programmer",
                    "Museum Technician / Preparator"
                ],
                "Archaeology, History & Anthropology" => [
                    "Archaeologist",
                    "Cultural Anthropologist",
                    "Genealogist",
                    "Historian",
                    "Researcher (Cultural/Heritage focus)"
                ],
                "Cultural Heritage Management & Preservation" => [
                    "Cultural Heritage Manager",
                    "Cultural Resource Manager (CRM)",
                    "Historic Preservation Officer / Specialist",
                    "Site Manager (Historic Sites)",
                    "Tribal Historic Preservation Officer"
                ],
                "Interpretation & Communication" => [
                    "Cultural Events Coordinator / Planner",
                    "Heritage Interpreter / Tour Guide",
                    "Photographer (Archival/Heritage focus)"
                ]
            ],
            "Earth & Atmospheric Sciences" => [
                "Geology & Geophysics" => [
                    "Environmental Geologist",
                    "Geochemist",
                    "Geological Engineer",
                    "Geologist",
                    "Geomorphologist",
                    "Geophysicist",
                    "Glaciologist",
                    "Hydrogeologist",
                    "Marine Geologist",
                    "Mineralogist",
                    "Paleontologist",
                    "Petrologist",
                    "Planetary Geologist",
                    "Seismologist",
                    "Stratigrapher",
                    "Volcanologist"
                ],
                "Atmospheric & Climate Science" => [
                    "Atmospheric Scientist",
                    "Climate Scientist",
                    "Climatologist",
                    "Meteorologist"
                ],
                "Oceanography & Marine Science" => [
                    "Oceanographer"
                ],
                "Geospatial & Remote Sensing" => [
                    "Cartographer",
                    "GIS Specialist",
                    "Remote Sensing Scientist"
                ],
                "Soil Science" => [
                    "Soil Scientist"
                ]
            ],
            "Architecture, Design & Built Environment" => [
                "Architectural Practice & Design" => [
                    "Architect",
                    "Architect (Licensed)",
                    "Architectural Designer",
                    "Design Architect",
                    "Interior Architect",
                    "Project Architect",
                    "Research Architect",
                    "Restoration Architect",
                    "Specification Writer (Architecture)",
                    "Sustainable/Green Building Architect"
                ],
                "Architectural Technology & Visualization" => [
                    "Architectural Modeler (3D)",
                    "Architectural Renderer / Visualizer",
                    "Architectural Technologist",
                    "BIM (Building Information Modeling) Specialist/Manager"
                ],
                "Building Performance & Science" => [
                    "Building Performance Analyst",
                    "Building Scientist"
                ],
                "Specialized Architectural Consulting" => [
                    "Accessibility Consultant (Architectural)",
                    "Acoustic Consultant (Architectural)",
                    "Façade Engineer",
                    "Lighting Designer (Architectural)"
                ],
                "Urban Planning & Landscape Design" => [
                    "Facilities Planner",
                    "Landscape Architect",
                    "Urban Designer",
                    "Urban Planner (Architectural background)"
                ],
                "Historic Preservation & Conservation (Built Environment Focus)" => [
                    "Conservation Architect",
                    "Museum Conservation Officer",
                    "Construction Administrator (Architecture)",
                    "Museum or Art Gallery Curator"
                ]
            ],
            "Retail, Sales & Merchandising" => [
                "Retail Operations & Management" => [
                    "Auctioneer",
                    "Builders' Merchant",
                    "Cashier",
                    "Garden Center Worker",
                    "Inventory Manager",
                    "Loss Prevention Officer",
                    "Pet Shop Assistant",
                    "Production Demonstrator",
                    "Retail Assistant",
                    "Retail Manager",
                    "Retail Operations Manager",
                    "Retail Planner",
                    "Stock Associate",
                    "Supermarket Assistant",
                    "Visual Merchandiser"
                ],
                "Sales & Business Development" => [
                    "Customer Relation Manager",
                    "Export Sales Manager",
                    "Medical Representative",
                    "Sales Director",
                    "Sales Engineer",
                    "Sales Representative",
                    "Vehicle Salesperson",
                    "Wholesale Representative"
                ],
                "Category & Product Management" => [
                    "Category Manager",
                    "Online Merchandiser"
                ],
                "Specialized Retail/Sales" => [
                    "Jeweller",
                    "Optical Assistant",
                    "Showroom Manager"
                ]
            ]
        ];

        $categoryIcons = [
            "Business Operations & Management" => "fas fa-briefcase",
            "Finance & Accounting Professions" => "fas fa-money-bill-wave",
            "Arts, Entertainment & Production" => "fas fa-theater-masks",
            "Alternative & Holistic Health Practices" => "fas fa-leaf",
            "Legal & Judicial Support" => "fas fa-balance-scale",
            "Advisory, Consulting & Coaching" => "fas fa-lightbulb",
            "Legal Profession & Judiciary" => "fas fa-gavel",
            "Agriculture" => "fas fa-tractor",
            "Engineering & Technical Sciences" => "fas fa-cogs",
            "Environmental Science, Sustainability & Conservation" => "fas fa-globe",
            "Aviation & Aerospace Operations" => "fas fa-plane",
            "Ambulance Services and Emergency Services" => "fas fa-ambulance",
            "Information Technology (IT) & Software Development" => "fas fa-laptop-code",
            "Healthcare & Medical Support Services" => "fas fa-stethoscope",
            "Animal Care, Welfare & Science" => "fas fa-paw",
            "Art, Design & Visual Media" => "fas fa-paint-brush",
            "Horticulture, Landscaping, and Botanical Science" => "fas fa-seedling",
            "Heritage, Archives & Museum Professions" => "fas fa-landmark",
            "Earth & Atmospheric Sciences" => "fas fa-mountain",
            "Architecture, Design & Built Environment" => "fas fa-building",
            "Retail, Sales & Merchandising" => "fas fa-shopping-cart"
        ];

        $subCategoryIcons = [
            "Human Resources (HR) & People Management" => "fas fa-users",
            "Administrative & Clerical Support" => "fas fa-file-alt",
            "Operations & Project Management" => "fas fa-tasks",
            "Marketing & Communications" => "fas fa-bullhorn",
            "Customer Service & Sales" => "fas fa-headset",
            "Procurement & Supply Chain" => "fas fa-truck",
            "Banking & Retail Finance" => "fas fa-piggy-bank",
            "General Management & Consulting" => "fas fa-chart-line",
            "Investment & Capital Markets" => "fas fa-chart-bar",
            "Accounting & Auditing" => "fas fa-calculator",
            "Insurance & Risk Management" => "fas fa-shield-alt",
            "Financial Advisory & Planning" => "fas fa-hand-holding-usd",
            "Corporate Finance & Treasury" => "fas fa-coins",
            "Compliance" => "fas fa-check-circle",
            "Performance & Talent" => "fas fa-star",
            "Technical Production & Operations" => "fas fa-tools",
            "Set, Costume & Wardrobe" => "fas fa-tshirt",
            "Stage & Crew Management" => "fas fa-users-cog",
            "Venue Management" => "fas fa-building",
            "Bodywork & Manual Therapies" => "fas fa-hand-holding-heart",
            "Traditional & Energy-Based Systems" => "fas fa-yin-yang",
            "Mind-Body & Behavioral Practices" => "fas fa-brain",
            "Nutritional & Botanical Therapies" => "fas fa-seedling",
            "Integrative & Naturopathic Medicine" => "fas fa-prescription-bottle-alt",
            "Specialized Legal Roles" => "fas fa-balance-scale-right",
            "Legal Support & Paralegal" => "fas fa-file-contract",
            "Court & Administrative Support" => "fas fa-gavel",
            "Lawyers & Attorneys (General Practice & Specializations)" => "fas fa-briefcase",
            "Judiciary & Court Officials" => "fas fa-gavel",
            "Legal Research & Academia" => "fas fa-book",
            "Farm & Land Management" => "fas fa-tractor",
            "Agricultural Science & Research" => "fas fa-flask",
            "Advisory, Extension & Consulting (Agriculture-Specific)" => "fas fa-hand-holding-seedling",
            "Specialized Agricultural Roles" => "fas fa-leaf",
            "Agricultural Business & Marketing" => "fas fa-chart-pie",
            "Forestry & Related Management" => "fas fa-tree",
            "Aerospace & Aeronautical Engineering" => "fas fa-plane",
            "Civil & Structural Engineering" => "fas fa-hard-hat",
            "Electrical & Electronics Engineering" => "fas fa-bolt",
            "Mechanical & Industrial Engineering" => "fas fa-wrench",
            "Chemical & Process Engineering" => "fas fa-flask",
            "Computer & Software Engineering/IT" => "fas fa-laptop-code",
            "Environmental Engineering & Science (Broader Scope)" => "fas fa-globe-americas",
            "Biomedical & Healthcare Engineering" => "fas fa-stethoscope",
            "Geoscience & Mining Engineering" => "fas fa-mountain",
            "Specialized Engineering & Research Roles" => "fas fa-cogs",
            "Environmental Management & Policy" => "fas fa-globe",
            "Environmental Science & Research" => "fas fa-microscope",
            "Environmental Engineering & Technical Specialists" => "fas fa-tools",
            "Environmental Advisory & Education" => "fas fa-chalkboard-teacher",
            "Forestry & Related" => "fas fa-tree",
            "Permitting & Regulatory" => "fas fa-stamp",
            "Flight Operations & Piloting" => "fas fa-plane-departure",
            "Cabin & Passenger Services" => "fas fa-user-friends",
            "Ground Operations & Support" => "fas fa-traffic-light",
            "Aviation Maintenance & Technical" => "fas fa-tools",
            "Aviation Education & Analysis" => "fas fa-chalkboard",
            "Ambulance & Paramedical Services" => "fas fa-ambulance",
            "Emergency Communications & Coordination" => "fas fa-phone-alt",
            "Fire & Hazardous Materials Response" => "fas fa-fire-extinguisher",
            "Law Enforcement & Public Safety" => "fas fa-shield-alt",
            "Rescue & Maritime Safety" => "fas fa-life-ring",
            "Emergency Medical Personnel (Hospital-based)" => "fas fa-hospital",
            "Training & Development (within Emergency Services)" => "fas fa-graduation-cap",
            "Software Development & Engineering" => "fas fa-code",
            "Specialized IT & Emerging Technologies" => "fas fa-robot",
            "Data & Infrastructure" => "fas fa-database",
            "Web Design & Management" => "fas fa-desktop",
            "Gaming Industry" => "fas fa-gamepad",
            "User Experience (UX) & Design" => "fas fa-paint-brush",
            "Clinical Diagnostics & Laboratory" => "fas fa-vial",
            "Therapeutic & Rehabilitation Services" => "fas fa-hand-holding-medical",
            "Specialized Clinical Support" => "fas fa-syringe",
            "Clinical Research & Technology" => "fas fa-microscope",
            "Direct Animal Care & Support" => "fas fa-paw",
            "Animal Health & Veterinary Medicine" => "fas fa-clinic-medical",
            "Animal Training & Behavior" => "fas fa-dog",
            "Animal Welfare & Rescue" => "fas fa-heart",
            "Zoo & Wildlife Science" => "fas fa-hippo",
            "Digital & 3D Art/Animation" => "fas fa-film",
            "Graphic & Illustrative Design" => "fas fa-image",
            "Fine Art & Traditional Media" => "fas fa-palette",
            "Immersive Media & Pre-Production" => "fas fa-vr-cardboard",
            "Horticultural Science & Research" => "fas fa-seedling",
            "Landscape & Grounds Management" => "fas fa-leaf",
            "Horticultural Consulting & Therapy" => "fas fa-hand-holding-seedling",
            "Archival & Collections Management" => "fas fa-archive",
            "Conservation & Restoration" => "fas fa-landmark",
            "Museum & Exhibition Roles" => "fas fa-university",
            "Archaeology, History & Anthropology" => "fas fa-scroll",
            "Cultural Heritage Management & Preservation" => "fas fa-monument",
            "Interpretation & Communication" => "fas fa-comment-alt",
            "Geology & Geophysics" => "fas fa-mountain",
            "Atmospheric & Climate Science" => "fas fa-cloud",
            "Oceanography & Marine Science" => "fas fa-water",
            "Geospatial & Remote Sensing" => "fas fa-map",
            "Soil Science" => "fas fa-seedling",
            "Architectural Practice & Design" => "fas fa-drafting-compass",
            "Architectural Technology & Visualization" => "fas fa-cubes",
            "Building Performance & Science" => "fas fa-tachometer-alt",
            "Specialized Architectural Consulting" => "fas fa-lightbulb",
            "Urban Planning & Landscape Design" => "fas fa-city",
            "Historic Preservation & Conservation (Built Environment Focus)" => "fas fa-landmark",
            "Retail Operations & Management" => "fas fa-store",
            "Sales & Business Development" => "fas fa-handshake",
            "Category & Product Management" => "fas fa-boxes",
            "Specialized Retail/Sales" => "fas fa-gem"
        ];

        $roleIcons = [
            "HR Assistant" => "fas fa-user-tie",
            "HR Coordinator" => "fas fa-users-cog",
            "HR Director" => "fas fa-user-shield",
            "HR Generalist" => "fas fa-user-check",
            "HR Manager" => "fas fa-user-gear",
            "Chief Human Resources Officer" => "fas fa-crown",
            "Employee Relations Manager" => "fas fa-handshake",
            "Payroll Specialist" => "fas fa-money-check-alt",
            "Recruitment Consultant" => "fas fa-user-plus",
            "Recruitment Manager" => "fas fa-users",
            "Diversity, Equity, and Inclusion (DEI) Officer/Specialist" => "fas fa-globe",
            "Compensation Specialist" => "fas fa-balance-scale",
            "Benefits Administrator" => "fas fa-gift",
            "Clerical or Administrative Assistant" => "fas fa-file-alt",
            "Company Secretary" => "fas fa-file-signature",
            "Legal Secretary" => "fas fa-file-contract",
            "Medical Secretary" => "fas fa-file-medical",
            "Personal Assistant" => "fas fa-briefcase",
            "Receptionist" => "fas fa-phone-alt",
            "Office Manager" => "fas fa-building",
            "Operations Manager" => "fas fa-cogs",
            "Program Manager" => "fas fa-tasks",
            "Project Manager" => "fas fa-project-diagram",
            "Scrum Master" => "fas fa-sync",
            "Facilities Management" => "fas fa-tools",
            "Risk Manager" => "fas fa-exclamation-triangle",
            "Estimator" => "fas fa-calculator",
            "Market Research Interviewer" => "fas fa-clipboard-list",
            "Marketing Manager" => "fas fa-bullhorn",
            "Music Promotion Manager" => "fas fa-music",
            "PR & Communications Officer" => "fas fa-comment-alt",
            "Customer Service Administrator" => "fas fa-headset",
            "Sales Manager" => "fas fa-chart-line",
            "Procurement Administrator" => "fas fa-shopping-cart",
            "Procurement Manager" => "fas fa-truck",
            "Bank or Building Society Customer Adviser" => "fas fa-piggy-bank",
            "Bank or Building Society Manager" => "fas fa-university",
            "Bank Teller" => "fas fa-money-bill",
            "Branch Manager" => "fas fa-store",
            "Loan Officer" => "fas fa-hand-holding-usd",
            "Personal Banker" => "fas fa-user-friends",
            "Management Consultant" => "fas fa-lightbulb",
            "Business Adviser" => "fas fa-briefcase",
            "Debt Capital Markets (DCM) Analyst/Associate" => "fas fa-chart-bar",
            "Equity Capital Markets (ECM) Analyst/Associate" => "fas fa-chart-pie",
            "Investment Analyst (Buy - Side)" => "fas fa-search-dollar",
            "Investment Banker" => "fas fa-suitcase",
            "Investment Operations Administrator" => "fas fa-cogs",
            "Investor Relations Specialist" => "fas fa-handshake",
            "Mutual Fund Manager" => "fas fa-money-bill-wave",
            "Portfolio Manager" => "fas fa-briefcase",
            "Private Equity Assistant" => "fas fa-dollar-sign",
            "Venture Capital Analyst/Associate" => "fas fa-seedling",
            "Account Assistant" => "fas fa-book",
            "Accountant" => "fas fa-calculator",
            "Tax Accountant" => "fas fa-file-invoice-dollar",
            "Auditor" => "fas fa-search",
            "Financial Examiner" => "fas fa-check-circle",
            "Insurance Account Manager" => "fas fa-shield-alt",
            "Actuary" => "fas fa-chart-area",
            "Claim Adjuster" => "fas fa-clipboard-check",
            "Insurance Broker" => "fas fa-user-tie",
            "Insurance Claim Handler" => "fas fa-file-medical-alt",
            "Insurance Risk Surveyor" => "fas fa-exclamation",
            "Insurance Underwriter" => "fas fa-pen",
            "Financial Analyst (Corporate)" => "fas fa-chart-line",
            "Chief Financial Officer" => "fas fa-crown",
            "Treasury Analyst/Manager" => "fas fa-coins",
            "Compliance Officer" => "fas fa-balance-scale",
            "Actor" => "fas fa-theater-masks",
            "Stunt Performer" => "fas fa-running",
            "Assistant Technical Director" => "fas fa-wrench",
            "Technical Director" => "fas fa-tools",
            "Event Technician" => "fas fa-cog",
            "Theatre Technician" => "fas fa-lightbulb",
            "Master Electrician" => "fas fa-bolt",
            "Lighting Manager" => "fas fa-lightbulb",
            "Pyro Technician" => "fas fa-fire",
            "Rigging & Automation" => "fas fa-cogs",
            "Sound Manager" => "fas fa-volume-up",
            "Special Effect Specialist" => "fas fa-magic",
            "Scenic Artist" => "fas fa-paint-brush",
            "Set Designer" => "fas fa-drafting-compass",
            "Costume Technician" => "fas fa-tshirt",
            "Dresser" => "fas fa-hanger",
            "Wardrobe Assistant - Film, TV or Theatre" => "fas fa-wardrobe",
            "Crew Member" => "fas fa-users",
            "Stage Manager" => "fas fa-clipboard",
            "Stagehand" => "fas fa-hand-holding",
            "Venue Manager" => "fas fa-building",
            "default" => "fas fa-briefcase"
        ];

        $rows = [];

        foreach ($mixedCategories as $category => $subCategories) {
            $categoryIcon = $categoryIcons[$category] ?? 'fas fa-briefcase';

            foreach ($subCategories as $subCategory => $roles) {
                $subCategoryIcon = $subCategoryIcons[$subCategory] ?? 'fas fa-briefcase';

                foreach ($roles as $role) {
                    $roleIcon = $roleIcons[$role] ?? 'fas fa-briefcase';

                    $rows[] = [
                        'category' => $category,
                        'category_icon' => $categoryIcon,
                        'subcategory' => $subCategory,
                        'subcategory_icon' => $subCategoryIcon,
                        'role' => $role,
                        'role_icon' => $roleIcon
                    ];
                }
            }
        }

        return $rows;
    }

    /**
     * Generates HTML <option> elements from hustle categories array.
     *
     * @return string HTML string for <select> options
     */
    public static function hustleCategoriesDropdownOptions(): string
    {
        $categories = self::hustleCategories();

        $options = '<option value="">-- Select Category --</option>';
        foreach ($categories as $category) {
            $options .= '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
        }

        return $options;
    }
}
