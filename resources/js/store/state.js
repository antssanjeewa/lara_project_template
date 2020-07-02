export default {

    url :'http://http://localhost/office-web-application/public/',
    message : '',
    loader : false,

    themeData : {
        color : {
            appTheme : false,
            background : "white",
            topBarTheme : true,

            // toolbar
            topToolBar : "#f57f19",
            totalnumber : "lime--text",
            addNewButton : 'primary',
            search : 'grey',

            // tableHeader : 'grey darken-2',
            tableHeader : '#535353',

            // form dialog
            formHeaderEdit : 'grey darken-2',
            formHeaderNew : 'primary',

            // data table action
            defaltButton : '#9E9E9E',
            viewButton : 'green',
            editButton : 'blue',
            deleteButton : 'red',

            paragraphText : '',
            headerText : '',

        

        },
        drawer: {
            model: null,
            type: 'default (no property)',
            clipped: true,
            floating: false,
            mini: false
        },
        footer: {
            inset: false
        } 
    }

}