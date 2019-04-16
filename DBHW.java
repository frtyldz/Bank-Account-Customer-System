package dbhw;
import java.sql.*;
/**
 *
 * @author firatyildiz
 */
public class DBHW {
    public static void main(String[] args){
        //String connect = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/firat_yildiz";
        String customer, account, owns;
        String custInf, accInf, ownsInf;
        try{
            //create connection
            Class.forName("com.mysql.cj.jdbc.Driver");
            System.out.println("Connect to the database system in dijkstra");
            Connection c_conn = DriverManager.getConnection("jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/firat_yildiz", "user", "password");
            System.out.println("Connection is done!");
            
            //drop the tables if any
            Statement s_stat = c_conn.createStatement();
            s_stat.execute("DROP TABLE IF EXISTS owns");
            s_stat.execute("DROP TABLE IF EXISTS account");
            s_stat.execute("DROP TABLE IF EXISTS customer");
            
           
            System.out.println("Drop of existing tables is done!");
            
           //creating the tables
           
           customer =   "CREATE TABLE customer" +
			"( cid char(12)," +
			"  name varchar(50)," +
			"  bdate date," +
			"  address varchar(50)," +
			"  city varchar(20)," +
			"  nationality varchar(20)," +
			"  PRIMARY KEY(cid) " +
			")ENGINE=InnoDB;";
           
            account =   "CREATE TABLE account" +
                        "( aid char(8)," +
                        "  branch varchar(20)," +
			"  balance float," +
                        "  openDate date," +
			"  PRIMARY KEY(aid)" +
			")ENGINE=InnoDB;";;
            
            owns = "CREATE TABLE owns" +
                    "( cid char(12)," +
                    "  aid char(8)," +
                    "  PRIMARY KEY (cid,aid)," +
                    "  FOREIGN KEY (cid) REFERENCES customer(cid)," +
                    "  FOREIGN KEY (aid) REFERENCES account(aid)" +
                    ")ENGINE=InnoDB;";
            
            System.out.println("Implementation of tables are done!");
            
            //executing the tables
            s_stat.execute(account);
            s_stat.execute("ALTER TABLE account ENGINE=InnoDB;");
            s_stat.execute(customer);
            s_stat.execute("ALTER TABLE customer ENGINE=InnoDB;");
            s_stat.execute(owns);
            s_stat.execute("ALTER TABLE owns ENGINE=InnoDB;");
            
            System.out.println("Tables are executed!");
            
            
            //informations are created and add
            custInf = "INSERT INTO customer VALUES" +
                    "(20000001, 'Cem', '1980-10-10', 'Tunali', 'Ankara', 'TC')," +
                    "(20000002, 'Asli', '1985-09-08', 'Nisantasi', 'Istanbul', 'TC')," +
                    "(20000003, 'Ahmet', '1995-02-11', 'Karsiyaka', 'Izmir', 'TC')," +
                    "(20000004, 'John', '1995-04-16', 'Kizilay', 'Ankara', 'ABD');";
            
            accInf = "INSERT INTO account VALUES" +
                    "('A0000001', 'Kizilay', 2000, '1980-10-10')," +
                    "('A0000002', 'Bilkent', 8000, '1985-09-08')," +
                    "('A0000003', 'Cankaya', 4000, '1995-02-11')," +
                    "('A0000004', 'Sincan', 1000, '1995-04-16'),"+
                    "('A0000005', 'Tandogan', 3000, '1985-09-08')," +
                    "('A0000006', 'Eryaman', 5000, '1995-02-11')," +
                    "('A0000007', 'Umitkoy', 6000, '1995-04-16');";
            
            ownsInf = "INSERT INTO owns VALUES" +
                    "(20000001, 'A0000001')," +
                    "(20000001, 'A0000002')," +
                    "(20000001, 'A0000003')," +
                    "(20000001, 'A0000004')," +
                    "(20000002, 'A0000002')," +
                    "(20000002, 'A0000003')," +
                    "(20000002, 'A0000005')," +
                    "(20000003, 'A0000006')," +
                    "(20000003, 'A0000007')," +
                    "(20000004, 'A0000006');";
            
            s_stat.execute(accInf);
            s_stat.execute(custInf);
            s_stat.execute(ownsInf);
            System.out.println("Informations are add into the tables succesfully!");
            
            
            // check the table customer if it is add
            String ow = "SELECT * FROM owns";
            ResultSet set = s_stat.executeQuery(ow);
            while (set.next()) {
                String cid = set.getString("cid");
                String aid = set.getString("aid");
                System.out.println("Customer id: " + cid);
                System.out.println("Account id: " + aid);
            }
            
         }catch (SQLException | ClassNotFoundException e) {
            System.err.println("Error Statement or Connection Failed!!!!");
            e.printStackTrace();
        }
        
    }
    
}
