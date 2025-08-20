# Student Import/Export Guide

## Overview
The StudentResource now supports importing and exporting student data via Excel files. This feature allows administrators to bulk manage student records efficiently.

## Export Features

### Exporting Students
1. Navigate to **User Management > Students**
2. Click the **"Export Students"** button (📥 icon) in the top-right corner
3. Choose your preferred format (Excel, CSV)
4. Download the file

### Exported Data Includes:
- Student Name
- Student ID
- Study Program
- Faculty
- Enrollment Year
- Current Semester
- GPA
- Academic Advisor
- Status
- Email
- Phone
- Created/Updated timestamps

## Import Features

### Importing Students
1. Navigate to **User Management > Students**
2. Click the **"Import Students"** button (📤 icon) in the top-right corner
3. Download the template (optional but recommended)
4. Fill in your Excel file with student data
5. Upload the file
6. Review and confirm the import

### Import Template Columns:

| Column | Required | Description | Validation |
|--------|----------|-------------|------------|
| Student Name | ✅ | Full name of the student | Required, max 255 chars |
| Email | ✅ | Student's email address | Required, unique, valid email |
| Phone | ❌ | Student's phone number | Optional, max 20 chars |
| Student ID | ✅ | Unique student identifier | Required, unique, max 50 chars |
| Study Program | ✅ | Student's study program | Required, max 255 chars |
| Faculty | ✅ | Student's faculty | Required, max 255 chars |
| Department | ❌ | Student's department | Optional, max 255 chars |
| Enrollment Year | ✅ | Year student enrolled | Required, 2000-2030 |
| Current Semester | ✅ | Current semester | Required, 1-14 |
| GPA | ❌ | Grade Point Average | Optional, 0-4 scale |
| Advisor Email | ❌ | Academic advisor's email | Optional, must exist in system |
| Status | ✅ | Student status | Required: active/graduated/suspended/dropped |

### Import Behavior:
- **New Students**: Creates new user accounts and student profiles
- **Existing Students**: Updates existing profiles (matched by Student ID)
- **User Creation**: Automatically creates user accounts with student type
- **Password**: New users get default password "password123"
- **Advisor Assignment**: Links to existing users by email

### Import Tips:
1. **Use the template**: Download the template to ensure correct column structure
2. **Check data**: Verify all required fields are filled
3. **Unique IDs**: Ensure Student IDs are unique
4. **Valid emails**: Use valid email formats
5. **Advisor emails**: Must match existing user emails in the system

## Error Handling

### Common Import Errors:
- **Duplicate Student ID**: Student ID already exists
- **Invalid Email**: Email format is incorrect
- **Missing Required Fields**: Required columns are empty
- **Invalid Status**: Status not in allowed values
- **Advisor Not Found**: Advisor email doesn't exist in system

### Export Errors:
- **No Data**: No students to export
- **Permission Issues**: Insufficient permissions

## Best Practices

### For Import:
1. **Test with small files first**
2. **Backup existing data**
3. **Validate data before import**
4. **Use consistent formatting**
5. **Check for duplicates**

### For Export:
1. **Filter data before export**
2. **Use appropriate date ranges**
3. **Export regularly for backups**
4. **Share exports securely**

## Security Notes

- Import/Export requires appropriate permissions
- Sensitive data (passwords) are not exported
- Import files are processed securely
- Failed imports are logged for review

## Support

If you encounter issues with import/export:
1. Check the error messages in the import summary
2. Verify your Excel file format
3. Ensure all required fields are filled
4. Contact system administrator for assistance 
