
package travel.management.system;

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;

public class CheckPackage extends JFrame implements ActionListener{
    JButton book;
    String username;
    CheckPackage(String username){
        this.username = username;
        setBounds(450,200,900,600);
        
        String[] package1 = {"Gold Package", "6 Days & 7 Nights","Airport Assistance","Half Day City tour","Daily Buffet","Welcome drinks no Arrival","Full Day 3 island cruise","English speaking guid","Book Now","Summer Special","Rs 12000/-","package1.jpg"};
        String[] package2 = {"Silver Package","5 Days & 6 Nights","Toll Free & Entrance Free Tickets","Half Day City tour","Meet & Greet at Airport","Welcome drinks no Arrival","Night Safari","Cruise with Dinner","Book Now","Winter Special","Rs 24000/-","package2.jpg"};
        String[] package3 = {"Bronze Package","5 Days & 6 Nights","Return Airfare","Free Clubbing","Horse Riding & River Rougnting","Welcome drinks no Arrival","Daile Buffet","BBQ Dinner","Book Now","Winter Special","Rs 32000/-","package3.jpg"};
        
        JTabbedPane tab = new JTabbedPane();
        JPanel p1 =createPackage(package1);
        tab.addTab("Package 1",null, p1);
        JPanel p2 =createPackage(package2);
        tab.addTab("Package 2",null, p2);
        JPanel p3 =createPackage(package3);
        tab.addTab("Package 3",null, p3);
        
        
        
        add(tab);
        
        
        setVisible(true);
    }

    public JPanel createPackage(String[] pack){
        
        JPanel p1 = new JPanel();
        p1.setLayout(null);
        p1.setBackground(Color.WHITE);
        
        JLabel l1 = new JLabel(pack[0]);
        l1.setBounds(50, 5, 300, 30);
        l1.setForeground(Color.YELLOW);
        l1.setFont(new Font("Tahoma",Font.BOLD,30));
        p1.add(l1);
        
        JLabel l2 = new JLabel(pack[1]);
        l2.setBounds(30, 60, 300, 30);
        l2.setForeground(Color.RED);
        l2.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l2);
        
        JLabel l3 = new JLabel(pack[2]);
        l3.setBounds(30, 110, 300, 30);
        l3.setForeground(Color.BLUE);
        l3.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l3);
        
        JLabel l4 = new JLabel(pack[3]);
        l4.setBounds(30, 160, 300, 30);
        l4.setForeground(Color.RED);
        l4.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l4);
        
        JLabel l5 = new JLabel(pack[4]);
        l5.setBounds(30, 210, 300, 30);
        l5.setForeground(Color.BLUE);
        l5.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l5);
        
        JLabel l6 = new JLabel(pack[5]);
        l6.setBounds(30, 260, 300, 30);
        l6.setForeground(Color.RED);
        l6.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l6);
        
        JLabel l7 = new JLabel(pack[6]);
        l7.setBounds(30, 310, 300, 30);
        l7.setForeground(Color.BLUE);
        l7.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l7);
        
        JLabel l8 = new JLabel(pack[7]);
        l8.setBounds(30, 360, 300, 30);
        l8.setForeground(Color.RED);
        l8.setFont(new Font("Tahoma",Font.BOLD,20));
        p1.add(l8);
        
        book= new JButton(pack[8]);
        book.setBounds(300, 430, 280, 30);
        book.setForeground(Color.WHITE);
        book.setBackground(Color.BLACK);
        book.setFont(new Font("Tahoma",Font.BOLD,25));
        book.addActionListener(this);
        p1.add(book);
        
        JLabel l9 = new JLabel(pack[9]);
        l9.setBounds(80, 480, 300, 30);
        l9.setForeground(Color.MAGENTA);
        l9.setFont(new Font("Tahoma",Font.BOLD,25));
        p1.add(l9);
        
        JLabel l10 = new JLabel(pack[10]);
        l10.setBounds(650, 480, 300, 30);
        l10.setForeground(Color.CYAN);
        l10.setFont(new Font("Tahoma",Font.BOLD,25));
        p1.add(l10);
        
        ImageIcon i1 = new ImageIcon(ClassLoader.getSystemResource("icons/"+pack[11]));
        Image i2 = i1.getImage().getScaledInstance(500, 300, Image.SCALE_DEFAULT);
        ImageIcon i3 = new ImageIcon(i2);
        JLabel image = new JLabel(i3);
        image.setBounds(350,20,500,300);
        p1.add(image);
        
        return p1;
    }
    public void actionPerformed(ActionEvent ae){
        if(ae.getSource() == book){
         setVisible(false);
         new BookPackage(username);
        }
    }
    
    public static void main(String[] args){
        new CheckPackage("");
    }
}
