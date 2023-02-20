export const Title = (props) => {
    return 'Nama Saya : ' + props.name; 
};

Title.defaultProps = {
    name : 'Panjul',
};