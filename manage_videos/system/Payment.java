package travel.management.system;

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;

public class Payment extends JFrame implements ActionListener{
    JButton pay,back;
     Payment(){
         setBounds(500,200,800,600);
         setLayout(null);
         
         ImageIcon i1 = new ImageIcon(ClassLoader.getSystemResource("icons/paytm.jpeg"));
         Image i2 = i1.getImage().getScaledInstance(800, 600, Image.SCALE_DEFAULT);
         ImageIcon i3 = new ImageIcon(i2);
         JLabel image = new JLabel(i3);
         image.setBounds(0,0,800,600);
         add(image);
         
         pay = new JButton("Pay Here");
         pay.setBounds(345, 180, 110, 40);
         pay.setBackground(Color.BLUE);
         pay.setForeground(Color.WHITE);
         pay.setFont(new Font("Tahoma",Font.BOLD,16));
         pay.addActionListener(this);
         image.add(pay);
         
         back = new JButton("Back");
         back.setBounds(690, 510, 80, 40);
         back.setBackground(Color.BLUE);
         back.setForeground(Color.WHITE);
         back.setFont(new Font("Tahoma",Font.PLAIN,16));
         back.addActionListener(this);
         image.add(back);
         
         setVisible(true);
     }
     public void actionPerformed(ActionEvent ae){
         if(ae.getSource() == pay){
             setVisible(false);
             new Paytm();
         }else{
             setVisible(false);
         }
     }
     
     public static void main(String[] args){
         new Payment();
     }
}
