package travel.management.system;

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import java.sql.*;

public class BookHotel extends JFrame implements ActionListener{
    
    String usernaem;
    Choice chotel, cac;
    JRadioButton rfoodincluded,rfoodnotincluded;
    JTextField tfpersons, tfdays;
    JLabel labelprice,labelusername,labelid,labelnumber,labelphone;
    JButton checkprice,bookpackage,back;
    
    BookHotel(String username){
        this.usernaem = username;
        setBounds(350,200,1100,600);
        setLayout(null);
        getContentPane().setBackground(Color.WHITE);
        
         JLabel text = new JLabel("Book Hotel");
        text.setBounds(100,10,200,30);
        text.setFont(new Font("Tahoma",Font.BOLD,20));
        add(text);
        
        JLabel lblusername = new JLabel("Username");
        lblusername.setBounds(40, 70, 100, 20);
        lblusername.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lblusername);
       
        labelusername = new JLabel();
        labelusername.setBounds(250, 70, 200, 20);
        labelusername.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(labelusername);
        
        
        JLabel lblpackage = new JLabel("Select Hotel");
        lblpackage.setBounds(40, 110, 150, 20);
        lblpackage.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lblpackage);
        
        chotel = new Choice();
        chotel.setBounds(250, 110, 200, 25);
        add(chotel);
        
        try{
            Conn c = new Conn();
            ResultSet rs = c.s.executeQuery("select * from hotel");
            while(rs.next()){
            chotel.add(rs.getString("name"));    
            }
        }catch (Exception e){
        e.printStackTrace();
        }
        
        JLabel lblpersons = new JLabel("Total Persons");
        lblpersons.setBounds(40, 150, 150, 20);
        lblpersons.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lblpersons);
        
        tfpersons = new JTextField("1");
        tfpersons.setBounds(250,150,200,25);
        add(tfpersons);
        
        
        JLabel lbldays = new JLabel("No. of Days");
        lbldays.setBounds(40, 190, 150, 20);
        lbldays.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lbldays);
        
        tfdays = new JTextField("1");
        tfdays.setBounds(250,190,200,25);
        add(tfdays);
        
        JLabel lblac = new JLabel("AC/Non-AC");
        lblac.setBounds(40, 230, 150, 20);
        lblac.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lblac);
        
        cac = new Choice();
        cac.add("AC");
        cac.add("Non-AC");
        cac.setBounds(250, 230, 200, 25);
        add(cac);

        
        JLabel lblfood = new JLabel("Food Included");
        lblfood.setBounds(40, 270, 150, 20);
        lblfood.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lblfood);
        
        
        rfoodincluded = new JRadioButton("Yes");
        rfoodincluded.setBounds(250, 270, 70, 20);
        rfoodincluded.setBackground(Color.WHITE);
        add(rfoodincluded);
        
        rfoodnotincluded = new JRadioButton("No");
        rfoodnotincluded.setBounds(380, 270, 70, 20);
        rfoodnotincluded.setBackground(Color.WHITE);
        add(rfoodnotincluded);
        
        ButtonGroup bg = new ButtonGroup();
        bg.add(rfoodincluded);
        bg.add(rfoodnotincluded);
        
        JLabel lblid = new JLabel("Id");
        lblid.setBounds(40, 310, 150, 20);
        lblid.setFont(new Font("Tahoma",Font.PLAIN,16));
        add(lblid);
        
        labelid = new JLabel();
        labelid.setBounds(250, 310, 200, 20);
        add(labelid);
        
        
        JLabel lblnumber = new JLabel("Number");
        lblnumber.setFont(new Font("Tahoma",Font.PLAIN,16));
        lblnumber.setBounds(40, 350, 150, 20);
        add(lblnumber);
        
        labelnumber = new JLabel();
        labelnumber.setBounds(250, 350, 150, 20);
        add(labelnumber);
        
        
        JLabel lblphone = new JLabel("Phone");
        lblphone.setFont(new Font("Tahoma",Font.PLAIN,16));
        lblphone.setBounds(40, 390, 150, 20);
        add(lblphone);
        
        labelphone = new JLabel();
        labelphone.setBounds(250, 390, 150, 20);
        add(labelphone);
        
        
        JLabel lbltotal = new JLabel("Total Price");
        lbltotal.setFont(new Font("Tahoma",Font.PLAIN,16));
        lbltotal.setBounds(40, 430, 150, 20);
        add(lbltotal);
        
       labelprice = new JLabel();
        labelprice.setBounds(250, 430, 150, 20);
        add(labelprice);
        
        
        try{
            Conn c = new Conn();
            String query = "select * from customer where username = '"+username+"'";
            ResultSet rs = c.s.executeQuery(query);
            while(rs.next()){
                labelusername.setText(rs.getString("username"));
                labelid.setText(rs.getString("id"));
                labelnumber.setText(rs.getString("number"));
                labelphone.setText(rs.getString("phone"));
                
            }
        }catch (Exception e){
            e.printStackTrace();
        }
        
        checkprice = new JButton("Check Price");
        checkprice.setBackground(Color.BLACK);
        checkprice.setForeground(Color.WHITE);
        checkprice.setBounds(60,490,120,25);
        checkprice.addActionListener(this);
        add(checkprice);
        
        bookpackage = new JButton("Book Hotel");
        bookpackage.setBackground(Color.BLACK);
        bookpackage.setForeground(Color.WHITE);
        bookpackage.setBounds(200,490,120,25);
        bookpackage.addActionListener(this);
        add(bookpackage);
        
        back = new JButton("Back");
        back.setBackground(Color.BLACK);
        back.setForeground(Color.WHITE);
        back.setBounds(340,490,120,25);
        back.addActionListener(this);
        add(back);
        
       
        
        ImageIcon i1= new ImageIcon(ClassLoader.getSystemResource("icons/book.jpg"));
        Image i2 = i1.getImage().getScaledInstance(600, 350, Image.SCALE_DEFAULT);
        ImageIcon i3= new ImageIcon(i2);
        JLabel image= new JLabel(i3);
        image.setBounds(550,50,600,350);
        add(image);
    
        
        setVisible(true);
    }
    

    public void actionPerformed(ActionEvent ae){

        if(ae.getSource() == checkprice){
            try{
                
                Conn c = new Conn();
                ResultSet rs = c.s.executeQuery("select * from hotel where name = '"+chotel.getSelectedItem()+"'");
                while(rs.next()){
                    int cost = Integer.parseInt(rs.getString("costperperson"));
                    int food = Integer.parseInt(rs.getString("foodincluded"));
                    int ac = Integer.parseInt(rs.getString("acroom"));
                    
                    int persons = Integer.parseInt(tfpersons.getText());
                    int days = Integer.parseInt(tfdays.getText());
                    String acselected = cac.getSelectedItem();
                    String foodincluded = null;
                    if(rfoodincluded.isSelected()){
                        foodincluded = "Yes";
                    }else{
                        foodincluded = "No";
                    }
                    
                    if(persons*days >0){
                        int total = 0;
                        total += acselected.equals("AC") ? ac : 0;
                        total += foodincluded.equals("Yes") ? food : 0;
                        total += cost;
                        total = total * persons * days;
                        labelprice.setText("" + total +"/-");
                    }else{
                        JOptionPane.showMessageDialog(null,"Please enter valid days or number");
                    }
                    
                }
                
            }catch (Exception e){
                e.printStackTrace();
            }
           
        }else if(ae.getSource() == bookpackage){
            
            String foodincluded = null;
            if(rfoodincluded.isSelected()){
                foodincluded = "Yes";
            }else{
                foodincluded = "No";
            }
            
            try{
                int input = JOptionPane.showConfirmDialog(null, "Book this Hotel?");
                if(input == 0){
                    Conn c = new Conn();
                    c.s.executeUpdate("insert into bookhotel values('"+labelusername.getText()+"','"+chotel.getSelectedItem()+"','"+tfpersons.getText()+"','"+tfdays.getText()+"','"+cac.getSelectedItem()+"','"+foodincluded+"','"+labelid.getText()+"','"+labelnumber.getText()+"','"+labelphone.getText()+"','"+labelprice.getText()+"')");

                    JOptionPane.showMessageDialog(null, "Hotel booked Successfully");
                    setVisible(false);
                }else if(input == 2){
                    setVisible(false);
                } 
            }catch (Exception e){
                e.printStackTrace();
           }       
            
        }  
        
        else if(ae.getSource() == back){
            setVisible(false);
        }
    }
    
    public static void main(String[] args){
        
        new BookHotel("");
    }
    
}
