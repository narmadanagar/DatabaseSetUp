SELECT distinct(fldDays), fldStart,fldStop FROM tblSections Join tblTeachers on fnkTeacherNetId = pmkNetId WHERE fldFirstName = 'Robert Raymond' and fldLastName = 'Snapp' order by fldDays
