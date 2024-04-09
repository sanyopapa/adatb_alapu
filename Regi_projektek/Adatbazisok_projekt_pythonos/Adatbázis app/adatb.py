import tkinter as tk
from tkinter import messagebox as MessageBox
import mysql.connector as mysql
from datetime import datetime, timedelta
import bcrypt
from tkcalendar import DateEntry

def mindent_torol():
    reg_email_label.place_forget()
    reg_nev_label.place_forget()
    reg_password_label.place_forget()
    reg_password_label1.place_forget()
    reg_email.place_forget()
    reg_nev.place_forget()
    reg_password.place_forget()
    reg_password1.place_forget()
    register_button.place_forget()
    login_email_label.place_forget()
    login_password_label.place_forget()
    login_email.place_forget()
    login_password.place_forget()
    login_button.place_forget()
    csatorna_label.place_forget()
    csatornak_listbox.place_forget()
    csatorna_kereses_nev.place_forget()
    csatorna_kereses_button.place_forget()
    csatorna_leiras_textbox.place_forget()
    csatornak_listazasa_button.place_forget()
    musor_label.place_forget()
    musorok_listbox.place_forget()
    musorok_listazasa_button.place_forget()
    musor_szereplo_kereses_szoveg.place_forget()
    musor_szereplok_kereses_button.place_forget()
    szereplo_adatok_listbox.place_forget()
    csatorna_kategoria.place_forget()
    csatorna_nev_label.place_forget()
    csatorna_kategoria_label.place_forget()
    csatorna_leiras_label.place_forget()
    epizod_kereses.place_forget()
    epizod_kereses_label.place_forget()
    epizod_kereses_textbox.place_forget()
    epizod_kereses_button.place_forget()
    musor_leiras.place_forget()
    musor_leiras_szoveg.place_forget()
    musor_leiras_textbox.place_forget()
    admin_email_label.place_forget()
    admin_nev_label.place_forget()
    admin_nev_text.place_forget()
    admin_email_text.place_forget()
    admin_profilt_torol_button.place_forget()
    admin_profilt_valtoztat_button.place_forget()
    admin_jelszo_label.place_forget()
    admin_jelszo_text.place_forget()
    admin_kijelentkezes_button.place_forget()
    csatornat_frissit_button.place_forget()
    csatornat_torol_button.place_forget()
    csatornat_hozzaad_button.place_forget()
    musor_mikor_label.place_forget()
    musor_hol_label.place_forget()
    musor_mikor.place_forget()
    musor_hol.place_forget()
    musort_hozzaad_button.place_forget()
    musort_torol_button.place_forget()
    musort_frissit_button.place_forget()
    szereplo_torlese_button.place_forget()
    szereplo_hozzaadasa_button.place_forget()
    szereplo_frissitese_button.place_forget()
    legfiatalabb_szereplok_nemzetisegenkent_button.place_forget()
    epizod_frissitese_button.place_forget()

def register():
    email = reg_email.get()
    nev = reg_nev.get()

    if email == "" or nev == "":
        MessageBox.showinfo("Info", "Az összes mező kitöltése kötelező")

    # Ellenőrizd, hogy mindkét jelszó mező kitöltve van-e
    if reg_password.get() == "" or reg_password1.get() == "":
        MessageBox.showinfo("Info", "Mindkét jelszó mező kitöltése kötelező")
        return

    # Ellenőrizd, hogy a két jelszó egyezik-e
    if reg_password.get() != reg_password1.get():
        MessageBox.showinfo("Info", "A jelszavak nem egyeznek")
        return

    # Ellenőrizd, hogy már létezik-e a felhasználó az adatbázisban
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()
    cursor.execute('SELECT * FROM admin WHERE Email = %s', (email,))
    existing_user = cursor.fetchall()
    con.close()

    if existing_user:
        MessageBox.showinfo('Info', 'Sikertelen regisztráció. Az e-mail cím már foglalt.')
    else:
        # Használd ugyanazt a sót minden hasheléshez
        salt = bcrypt.gensalt()
        password = bcrypt.hashpw(reg_password.get().encode('utf-8'), salt)

        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()
        cursor.execute('INSERT INTO admin (Email, Nev, Jelszo) VALUES (%s, %s, %s)', (email, nev, password))
        con.commit()
        con.close()

        MessageBox.showinfo('Info', 'Sikeres regisztráció')
        reg_email.delete(0, 'end')
        reg_nev.delete(0, 'end')
        reg_password.delete(0, 'end')
        reg_password1.delete(0, 'end')

def login():
    email = login_email.get()
    password = login_password.get()

    if email == "" or password == "":
        MessageBox.showinfo("Info", "Mindkét mező kitöltése kötelező")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    cursor.execute('SELECT * FROM admin WHERE Email = %s', (email,))
    rows = cursor.fetchall()

    if len(rows) > 0:
        stored_password = rows[0][2]

        if bcrypt.checkpw(password.encode('utf-8'), stored_password.encode('utf-8')):
            MessageBox.showinfo('Info', 'Sikeres bejelentkezés')
            global admin_email
            admin_email = email
            update_last_login(con, email)
            show_reglog_button.place_forget()
            show_profil_button.place(x=20, y=10)
            global bejelentkezett_e
            bejelentkezett_e = True
            mindent_torol()
            login_email.delete(0, 'end')
            login_password.delete(0, 'end')
            root.title("Admin nézet")

        else:
            MessageBox.showinfo('Info', 'Hibás jelszó')
    else:
        MessageBox.showinfo('Info', 'A felhasználó nem létezik')

    con.close()

def update_last_login(connection, email):
    update_query = 'UPDATE admin SET `Utolso_belepes` = %s WHERE `Email` = %s'
    current_time = datetime.now() + timedelta(hours=1)
    cursor = connection.cursor()
    cursor.execute(update_query, (current_time, email))
    connection.commit()
    cursor.close()

def show_reglog():
    mindent_torol()
    root.title("Bejelentkezés/regisztráció")
    reg_email_label.place(x=20, y=60)
    reg_nev_label.place(x=20, y=90)
    reg_password_label.place(x=20, y=120)
    reg_password_label1.place(x=20, y=150)
    reg_email.place(x=200, y=60)
    reg_nev.place(x=200, y=90)
    reg_password.place(x=200, y=120)
    reg_password1.place(x=200, y=150)
    register_button.place(x=20, y=190)
    login_email_label.place(x=20, y=250)
    login_password_label.place(x=20, y=280)
    login_email.place(x=200, y=250)
    login_password.place(x=200, y=280)
    login_button.place(x=20, y=310)

def show_csatornak():
    global bejelentkezett_e
    mindent_torol()
    root.title("Csatornák")
    csatorna_label.place(x=20, y=40)
    csatornak_listbox.place(x=20, y=60)
    csatornak_listazasa_button.place(x=20, y=180)
    csatorna_kereses_nev.place(x=200, y=60)
    csatorna_kereses_button.place(x=200, y=90)
    csatorna_leiras_textbox.place(x=200, y=130)
    csatorna_kategoria.place(x=200, y=230)
    csatorna_nev_label.place(x=320, y=60)
    csatorna_leiras_label.place(x=390, y=160)
    csatorna_kategoria_label.place(x=350, y=230)
    if bejelentkezett_e:
        csatornat_frissit_button.place(x=20, y=300)
        csatornat_torol_button.place(x=150, y=300)
        csatornat_hozzaad_button.place(x=280, y=300)

def show_epizodok():
    global bejelentkezett_e
    mindent_torol()
    root.title("Epizódok")
    epizod_kereses.place(x=20, y=60)
    epizod_kereses_label.place(x=20, y=40)
    epizod_kereses_textbox.place(x=20, y=130)
    epizod_kereses_button.place(x=20, y=90)
    if bejelentkezett_e:
        epizod_frissitese_button.place(x=20, y=230)

def show_musor():
    global bejelentkezett_e
    mindent_torol()
    root.title("Műsorok")
    musor_label.place(x=20, y=40)
    musorok_listbox.place(x=20, y=60)
    musorok_listazasa_button.place(x=20, y=150)
    musor_szereplo_kereses_szoveg.place(x=200, y=60)
    musor_szereplok_kereses_button.place(x=200, y=90)
    szereplo_adatok_listbox.place(x=200, y=130)
    musor_leiras_szoveg.place(x=20, y=220)
    musor_leiras.place(x=20, y=250)
    musor_leiras_textbox.place(x=20, y=280)
    legfiatalabb_szereplok_nemzetisegenkent_button.place(x=200, y=220)
    musor_mikor_label.place(x=20, y=380)
    musor_mikor.place(x=20, y=410)
    musor_hol_label.place(x=150, y=380)
    musor_hol.place(x=150, y=410)
    if bejelentkezett_e:
        musort_hozzaad_button.place(x=20, y=440)
        musort_torol_button.place(x=150, y=440)
        musort_frissit_button.place(x=280, y=440)
        szereplo_torlese_button.place(x=200, y=320)
        szereplo_hozzaadasa_button.place(x=200, y=290)
        szereplo_frissitese_button.place(x=200, y=260)

def csatornak_listazasa():
    # Lekérdezés az adatbázisból
    csatornak_list = lekerdez_csatornak()

    # Tisztítja a listboxot
    csatornak_listbox.delete(0, tk.END)

    # Hozzáadja az új adatokat a listboxhoz
    for csatorna in csatornak_list:
        csatornak_listbox.insert(tk.END, f"{csatorna[0]} - {csatorna[1]}")

def lekerdez_csatornak():
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    # Példa lekérdezés, amely kinyeri a csatornák nevét és kategóriáját
    cursor.execute('SELECT Nev, Kategoria FROM csatorna')
    csatornak_list = cursor.fetchall()

    con.close()

    return csatornak_list

def csatorna_leiras():
    # Csatorna nevének lekérése az entry mezőből
    csatorna_nev = csatorna_kereses_nev.get()

    if csatorna_nev == "":
        MessageBox.showinfo("Info", "Csatorna név megadása kötelező!")
        return

    # Adatbáziskapcsolat létrehozása
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        # Csatorna lekérése az adatbázisból
        cursor.execute('SELECT Leiras, Kategoria FROM csatorna WHERE Nev = %s', (csatorna_nev,))
        csatorna_data = cursor.fetchone()

        if csatorna_data:
            # Csatorna leírásának és kategóriájának beillesztése az entry mezőkbe
            csatorna_leiras_textbox.delete(1.0, tk.END)  # Törli a meglévő szöveget
            csatorna_leiras_textbox.insert(tk.END, csatorna_data[0])  # Beilleszti a leírást
            csatorna_kategoria.delete(0, tk.END)  # Törli a meglévő szöveget
            csatorna_kategoria.insert(0, csatorna_data[1])  # Beilleszti a kategóriát
        else:
            MessageBox.showinfo("Info", "Nincs ilyen nevű csatorna!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        # Adatbáziskapcsolat lezárása
        con.close()

def musorok_listazasa():
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT Cim FROM musor')
        musorok_list = cursor.fetchall()

        musorok_listbox.delete(0, tk.END)

        for musor in musorok_list:
            musorok_listbox.insert(tk.END, musor[0])

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()

def epizod_keres():
    # Törölje a korábbi adatokat az epizod_kereses_textbox-ból
    epizod_kereses_textbox.delete("1.0", tk.END)

    # Műsor nevének lekérése az entry mezőből
    keresett_musor = epizod_kereses.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        # Ellenőrizze, hogy van-e ilyen műsor
        cursor.execute('SELECT Cim FROM musor WHERE Cim = %s', (keresett_musor,))
        musor_exists = cursor.fetchone()

        if musor_exists:
            # Listázza az adott műsorhoz tartozó epizódokat
            cursor.execute('SELECT * FROM epizodok WHERE Cim = %s', (keresett_musor,))
            rows = cursor.fetchall()

            for row in rows:
                # Epizód adatainak hozzáadása a textbox-hoz
                epizod_kereses_textbox.insert(tk.END, f"Epizód: {row[1]}\n")
        else:
            # Ha nincs ilyen műsor, írja ki a megfelelő üzenetet
            epizod_kereses_textbox.insert(tk.END, "Nincs ilyen műsor!")

    except Exception as e:
        MessageBox.showerror("Hiba", f"Hiba történt: {str(e)}")
    finally:
        con.close()

def musor_leiras():
    # Az entry mezőből kiolvassuk a keresett műsor címét
    keresett_musor = musor_leiras_szoveg.get().lower()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        # Lekérdezzük a keresett műsor leírását az adatbázisból
        cursor.execute('SELECT Ismerteto FROM musor WHERE LOWER(Cim) = %s', (keresett_musor,))
        leiras = cursor.fetchone()

        if leiras:
            # Ha van találat, beírjuk a leírást a textboxba
            musor_leiras_textbox.delete(1.0, tk.END)
            musor_leiras_textbox.insert(tk.END, leiras[0])
        else:
            # Ha nincs találat, üresre állítjuk a textboxot és jelzünk
            musor_leiras_textbox.delete(1.0, tk.END)
            MessageBox.showinfo("Info", f"Nincs '{musor_leiras_szoveg.get()}' című műsor az adatbázisban!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()

def szereplok_listazasa():
    # Listázza ki ABC-sorrendben a felhasználó által kiválasztott műsor szereplőinek összes adatát!
    # Ha nem írtam be semmit akkor az összes szereplő adatát
    szereplo_adatok_listbox.delete("1.0", tk.END)

    keresett_szereplo = musor_szereplo_kereses_szoveg.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        if not keresett_szereplo:
            cursor.execute('SELECT * FROM szereplok ORDER BY Nev')
        else:
            cursor.execute('SELECT Cim FROM musor WHERE Cim = %s', (keresett_szereplo,))
            musor_exists = cursor.fetchone()

            if musor_exists:
                cursor.execute('SELECT * FROM szereplok WHERE Cim = %s ORDER BY Nev', (keresett_szereplo,))
            else:
                szereplo_adatok_listbox.insert(tk.END, "Nincs ilyen műsor!")
                return

        rows = cursor.fetchall()

        for row in rows:
            szereplo_adatok_listbox.insert(tk.END, f"Név: {row[4]}, Születési dátum: {row[1]}, Foglalkozás: {row[2]}, Nemzetiség: {row[3]}, Műsor: {row[0]}\n")

    except Exception as e:
        MessageBox.showerror("Hiba", f"Hiba történt: {str(e)}")
    finally:
        con.close()

def show_profile():
    global admin_email_text, admin_nev
    root.title("Profil")

    mindent_torol()

    # Az admin email címét írja bele az admin_email_text mezőbe
    admin_email_text = tk.Entry(root)
    admin_email_text.insert(0, admin_email)
    admin_email_text.place(x=200, y=60)

    # Keressük meg az admin nevét az adatbázisból
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()
    cursor.execute('SELECT Nev FROM admin WHERE Email = %s', (admin_email,))
    admin_nev = cursor.fetchone()
    con.close()

    # Az admin nevét írja bele az admin_nev_text mezőbe
    admin_nev_text.insert(0, admin_nev[0] if admin_nev else "")
    admin_nev_text.place(x=200, y=90)

    # Helyezze el az elemeket
    admin_email_label.place(x=20, y=60)
    admin_nev_label.place(x=20, y=90)
    admin_jelszo_label.place(x=20, y=120)
    admin_jelszo_text.place(x=200, y=120)
    admin_profilt_torol_button.place(x=20, y=150)
    admin_profilt_valtoztat_button.place(x=200, y=150)
    admin_kijelentkezes_button.place(x=380, y=150)

def delete_profile():
    global admin_email, bejelentkezett_e
    email = admin_email_text.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()
    try:
        cursor.execute('DELETE FROM admin WHERE Email = %s', (email,))
        con.commit()
        MessageBox.showinfo("Info", "Profil sikeresen törölve")
        mindent_torol()
        bejelentkezett_e = False
        admin_email = ""
        show_profil_button.place_forget()
        show_reglog_button.place(x=20, y=10)
    except Exception as e:
        con.rollback()
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")
    finally:
        con.close()

def update_profile():
    global admin_email, admin_nev

    new_email = admin_email_text.get()
    new_name = admin_nev_text.get()
    new_password = admin_jelszo_text.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    cursor.execute('SELECT * FROM admin WHERE Email = %s', (admin_email,))
    rows = cursor.fetchall()
    stored_password = rows[0][2]

    # Ellenőrizze, hogy változtattál-e valamit
    if (
        bcrypt.checkpw(new_password.encode('utf-8'), stored_password.encode('utf-8'))
        and admin_nev == new_name
        and admin_email == new_email
    ):
        MessageBox.showinfo("Info", "A profilon nem változtattál semmit!")
        return

    try:
        # Frissítse a jelszót, ha új jelszó van megadva
        if new_password:
            hashed_password = bcrypt.hashpw(new_password.encode('utf-8'), bcrypt.gensalt())
            cursor.execute(
                'UPDATE admin SET Email = %s, Nev = %s, Jelszo = %s WHERE Email = %s',
                (new_email, new_name, hashed_password, admin_email)
            )
        else:
            # Frissítse az email-t és a nevet
            cursor.execute('UPDATE admin SET Email = %s, Nev = %s WHERE Email = %s', (new_email, new_name, admin_email))

        con.commit()
        admin_email = new_email  # Frissítse a globális változókat
        admin_nev = new_name
        MessageBox.showinfo("Info", "Profil sikeresen frissítve")
    except Exception as e:
        con.rollback()
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")
    finally:
        con.close()

def logout():
    global admin_email, bejelentkezett_e
    bejelentkezett_e = False
    admin_email = ""
    mindent_torol()
    show_profil_button.place_forget()
    show_reglog_button.place(x=20, y=10)
    MessageBox.showinfo("Info", "Kijelentkezés megtörtént")

def csatornat_frissit():
    pass

if __name__ == '__main__':
    dbhost = 'localhost'
    dbuser = 'teszt'
    dbpass = 'teszt123'
    dbname = 'musorujsag'

    admin_email = ""
    admin_nev = ""
    bejelentkezett_e = False
    root = tk.Tk()
    root.geometry("500x600")
    root.title("Műsorújság")

    reg_email_label = tk.Label(root, text='Regisztráció - E-mail', font=('bold', 10))

    reg_nev_label = tk.Label(root, text='Regisztráció - Név', font=('bold', 10))

    reg_password_label = tk.Label(root, text='Regisztráció - Jelszó', font=('bold', 10))

    reg_password_label1 = tk.Label(root, text='            Jelszó ismét', font=('bold', 10))

    reg_email = tk.Entry()

    reg_nev = tk.Entry()

    reg_password = tk.Entry()

    reg_password1 = tk.Entry()

    register_button = tk.Button(root, text="Regisztráció", font=('italic', 10), bg="white", command=register)

    login_email_label = tk.Label(root, text='Bejelentkezés - E-mail', font=('bold', 10))

    login_password_label = tk.Label(root, text='Bejelentkezés - Jelszó', font=('bold', 10))

    login_email = tk.Entry()

    login_password = tk.Entry()

    login_button = tk.Button(root, text="Bejelentkezés", font=('italic', 10), bg="white", command=login)

    # navigációs gombok
    show_reglog_button = tk.Button(root, text="Reg/Log", font=('italic', 10), bg="white", command=show_reglog)
    show_reglog_button.place(x=20, y=10)

    show_csatornak_button = tk.Button(root, text="Csatornák", font=('italic', 10), bg="white", command=show_csatornak)
    show_csatornak_button.place(x=140, y=10)

    show_musor_button = tk.Button(root, text="Műsorok", font=('italic', 10), bg="white", command=show_musor)
    show_musor_button.place(x=260, y=10)

    show_epizodok_button = tk.Button(root, text="Epizódok", font=('italic', 10), bg="white", command=show_epizodok)
    show_epizodok_button.place(x=380, y=10)


    # Label a csatornák fejlécéhez
    csatorna_label = tk.Label(root, text="Csatornák")

    # Listbox a csatornákhoz
    csatornak_listbox = tk.Listbox(root, height=5, selectmode=tk.SINGLE)

    csatornak_listazasa_button = tk.Button(root, text="Csatornák listázása", font=('italic', 10), bg="white", command=csatornak_listazasa)

    csatorna_kereses_nev = tk.Entry()

    csatorna_kereses_button = tk.Button(root, text="Csatorna adatai", font=('italic', 10), bg="white", command=csatorna_leiras)

    csatorna_leiras_textbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)
    csatorna_leiras_textbox.insert(tk.END, "A keresett csatorna leírása")

    csatorna_kategoria = tk.Entry()

    csatorna_nev_label = tk.Label(root, text='- Név', font=('bold', 10))
    csatorna_leiras_label = tk.Label(root, text='- Leírás', font=('bold', 10))
    csatorna_kategoria_label = tk.Label(root, text='- Kategória', font=('bold', 10))

    # Műsor ablak
    musor_label = tk.Label(root, text="Műsorok")

    musorok_listbox = tk.Listbox(root, height=5,width=10,  selectmode=tk.SINGLE)

    musorok_listazasa_button = tk.Button(root, text="Műsorok listázása", font=('italic', 10), bg="white",
                                           command=musorok_listazasa)

    musor_szereplo_kereses_szoveg = tk.Entry()

    musor_szereplok_kereses_button = tk.Button(root, text="Szereplők listázása", font=('italic', 10), bg="white",
                                        command=szereplok_listazasa)

    szereplo_adatok_listbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)

    musor_leiras = tk.Button(root, text="Műsor adatai", font=('italic', 10), bg="white",
                                           command=musor_leiras)
    musor_leiras_szoveg = tk.Entry()

    musor_leiras_textbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)

    #Epizódok ablak
    epizod_kereses = tk.Entry()
    epizod_kereses_label = tk.Label(root, text='Műsor:', font=('bold', 10))
    epizod_kereses_textbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)
    epizod_kereses_button = tk.Button(root, text="Keresés", font=('italic', 10), bg="white",
                                     command=epizod_keres)

    #bejelentkezett mód
    show_profil_button = tk.Button(root, text="Profil", font=('italic', 10), bg="white",
                             command=show_profile)
    admin_email_label = tk.Label(root, text='Email:', font=('bold', 10))
    admin_nev_label = tk.Label(root, text='Név:', font=('bold', 10))
    admin_email_text = tk.Entry()
    admin_nev_text = tk.Entry()
    admin_jelszo_label = tk.Label(root, text='(Új)jelszó:', font=('bold', 10))
    admin_jelszo_text = tk.Entry()
    admin_profilt_torol_button = tk.Button(root, text="Profil törlése", font=('italic', 10), bg="white",
                             command=delete_profile)
    admin_profilt_valtoztat_button = tk.Button(root, text="Profil frissítése", font=('italic', 10), bg="white",
                             command=update_profile)
    admin_kijelentkezes_button = tk.Button(root, text="Kijelentkezés", font=('italic', 10), bg="white", command=logout)

    csatornat_frissit_button = tk.Button(root, text="Csatorna frissítése", font=('italic', 10), bg="white", command=csatornat_frissit)
    csatornat_torol_button = tk.Button(root, text="Csatorna törlése", font=('italic', 10), bg="white", command=csatornat_frissit)
    csatornat_hozzaad_button = tk.Button(root, text="Csatorna hozzáadása", font=('italic', 10), bg="white", command=csatornat_frissit)
    musor_mikor_label = tk.Label(root, text='Mikor vetítik:', font=('bold', 10))
    musor_hol_label = tk.Label(root, text='Hol vetítik:', font=('bold', 10))
    musor_mikor = DateEntry(root, width=12, background='darkblue', foreground='white', borderwidth=2)
    musor_hol = tk.Entry()
    musort_hozzaad_button = tk.Button(root, text="Műsor hozzáadása", font=('italic', 10), bg="white", command=csatornat_frissit)
    musort_torol_button = tk.Button(root, text="Műsor törlése", font=('italic', 10), bg="white", command=csatornat_frissit)
    musort_frissit_button = tk.Button(root, text="Műsor frissítése", font=('italic', 10), bg="white", command=csatornat_frissit)
    szereplo_torlese_button = tk.Button(root, text="Szereplő törlése", font=('italic', 10), bg="white", command=csatornat_frissit)
    szereplo_hozzaadasa_button = tk.Button(root, text="Szereplő hozzáadása", font=('italic', 10), bg="white", command=csatornat_frissit)
    szereplo_frissitese_button = tk.Button(root, text="Szereplő frissítése", font=('italic', 10), bg="white", command=csatornat_frissit)
    legfiatalabb_szereplok_nemzetisegenkent_button = tk.Button(root, text="Legfiatalabb szereplők", font=('italic', 10), bg="white", command=csatornat_frissit)
    epizod_frissitese_button = tk.Button(root, text="Epizódok frissítése", font=('italic', 10), bg="white", command=csatornat_frissit)

    root.mainloop()