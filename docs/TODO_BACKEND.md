### TODO (BACKEND)

#### ✅ Completed

##### Setup & Database

* [x] Test Database Connection Setup
* [x] Database Schema Verification
* [x] Dummy Admin User Created
* [x] Model Creation
* [x] Basic Route Configuration

##### Authentication

* [x] Authentication Controller
* [x] Login Functionality
* [x] Logout Functionality
* [x] Session Authentication
* [x] Authentication Filter (Middleware)
* [x] Basic Route Protection
* [x] Authentication Testing
* [x] Basic Login Validation Messages

##### Dashboard

* [x] Dashboard Controller
* [x] Protected Dashboard Page

##### Project Module

* [x] Project Controller
* [x] Project List Page
* [x] Project Detail Page Logic
* [x] Project Create Feature
* [x] Project Store Logic
* [x] Project Form Validation
* [x] Project Archive Feature
* [x] Project Access Restriction
* [x] Project Role Authorization

##### Project Member Module

* [x] Display Project Members
* [x] Add Member to Project
* [x] Basic Project Member Validation
* [x] Prevent Duplicate Project Members
* [x] Remove Member from Project
* [x] Project Member Management Authorization
* [x] Add Activity Log for Member Added
* [x] Add Activity Log for Member Removed

##### Task Module

* [x] Task Controller
* [x] Task Create Form
* [x] Task Store Logic
* [x] Basic Task Validation
* [x] Task Assignment
* [x] Display Tasks in Project Detail
* [x] Task Status Update
* [x] Basic Task Status Authorization

##### Comment Module

* [x] Comment Controller
* [x] Add Comment to Task
* [x] Display Task Comments
* [x] Basic Comment Validation

##### Activity Log Module

* [x] Activity Log Recording
* [x] Activity Log Display
* [x] Activity Log for Project Actions
* [x] Activity Log for Task Actions
* [x] Activity Log for Comment Actions

---

#### 🚧 In Progress / Partial

##### Project Module

* [ ] Project Edit Feature
* [ ] Project Update Logic
* [ ] Project Completed/Reopen Status Handling

##### Task Module

* [ ] Full Task CRUD
* [ ] Task Edit Feature
* [ ] Task Update Logic
* [ ] Task Delete/Archive Handling
* [ ] Deadline Handling

##### Comment Module

* [ ] Full Comment CRUD
* [ ] Comment Edit Feature
* [ ] Comment Delete Feature

##### Dashboard Backend

* [ ] Fix Activity Log Timestamp Display
* [ ] Format Activity Log Messages into Readable Text
* [ ] Create Dashboard Summary Query for Total Projects
* [ ] Create Dashboard Summary Query for Active Tasks
* [ ] Create Dashboard Summary Query for Tasks Due Today
* [ ] Create Dashboard Summary Query for Overdue Tasks
* [ ] Display Assigned Tasks for Logged-in User
* [ ] Display Nearest Deadlines
* [ ] Display Recent Team Activity
* [ ] Calculate Project Progress Percentage

---

#### ❌ Not Started

##### Authorization & Roles

* [ ] Define Clear `klien` Permission Rules
* [ ] Enforce `klien` View-Only Access
* [ ] Redirect Logged-in User Away from Login Page
* [ ] Final Permission Testing

##### Activity Log Improvements

* [ ] Standardize Activity Log Action Names
* [ ] Limit Recent Activity Logs Displayed

##### Validation & Security

* [ ] CSRF Protection Review
* [ ] Full Form Validation Review
* [ ] Authorization Checks Review
* [ ] Session Regeneration After Login
* [ ] Login Attempt Limit / Brute-force Protection
* [ ] Remove Temporary Test Routes and Test Controllers

##### Testing

* [ ] Project Flow Testing
* [ ] Project Member Flow Testing
* [ ] Task Flow Testing
* [ ] Comment Flow Testing
* [ ] Activity Log Testing
* [ ] Permission Testing
* [ ] Dashboard Data Testing

##### Future / Optional Features

* [ ] Member Role Update Feature
* [ ] User Account Management
* [ ] Avatar/Profile Update
* [ ] Notification or Reminder System for Deadlines
* [ ] Kanban Board Backend Data
* [ ] Timeline Backend Data
* [ ] Search Backend Logic for Projects and Tasks