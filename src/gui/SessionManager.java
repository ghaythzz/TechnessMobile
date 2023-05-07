 
package gui;
import com.codename1.io.Preferences;

public class SessionManager {

    public static Preferences pref; 

    private static String userName;
    private static String email;
    private static String passowrd;
    private static String prenom;
    private static String adresse;

    public static String getAdresse() {return adresse; }

    public static void setAdresse(String adresse) {SessionManager.adresse = adresse;}

    public static String getNumero() {return numero;}

    public static void setNumero(String numero) {SessionManager.numero = numero;}
    private static String numero;

    public static Preferences getPref() {return pref;}

    public static void setPref(Preferences pref) {SessionManager.pref = pref;}

    public static String getUserName() { return pref.get("username", userName);}

    public static void setUserName(String userName) {pref.set("username", userName);}

    public static String getPrenom() {return pref.get("prenom", prenom); }

    public static void setprenom(String prenom) {pref.set("prenom", prenom);}

    public static String getEmail() {return pref.get("email", email);}

    public static void setEmail(String email) { pref.set("email", email);}

    public static String getPassowrd() {return pref.get("passowrd", passowrd);}

    public static void setPassowrd(String passowrd) {pref.set("passowrd", passowrd);}
    
 
}
