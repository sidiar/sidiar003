
    function isValidDate(dateString) {
        // debugger;
        var dateStringSplit;
        var formatDate;

        if (dateString.length >= 8 && dateString.length <= 10) {
            try {
                dateStringSplit = dateString.split('-');
                var date = new Date();
                date.setYear(parseInt(dateStringSplit[0]), 10);
                date.setMonth(parseInt(dateStringSplit[1], 10) - 1);
                date.setDate(parseInt(dateStringSplit[2], 10));

                if (date.getFullYear() == parseInt(dateStringSplit[0], 10) && date.getMonth() + 1 == parseInt(dateStringSplit[1], 10) && date.getDate() == parseInt(dateStringSplit[2], 10)) {
                    return true;
                }
                else {
                    return false;
                }

            } catch (e) {
                return false;
            }
        }
        return false;
    }
