export default{
    dialog: false,
    itemList : [],
    asserts : [],
    activeItem : {},
    loginUser : {},
    
    item : {
        id:'',
        name:'',
        register_date : new Date().toISOString().substr(0, 10),
        roles:[]
    },
    defaultItem : {
        id:'',
        name:'',
        email : '',
        gender : '',
        birth_day : '',
        nic : '',
        state : 'active',
        roles:[],
        register_date : new Date().toISOString().substr(0, 10),
    }
 }