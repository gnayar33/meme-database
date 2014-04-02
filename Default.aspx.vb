Imports System.Data.OleDb
Imports System.Data
Imports System.Data.SqlClient

Partial Class _Default
    Inherits Page

    Private myDB As SqlConnection
    Private sqlCmd As SqlCommand
    Private myReader As SqlDataReader
    Private myConnection As String = ConfigurationManager.ConnectionStrings("ConnectionString2").ToString

    Protected Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        myDB = New SqlConnection(myConnection)
        sqlCmd = New SqlCommand("with belt (champ, startdate) as ( " & _
                               "select cast('" & TextBox2.Text & "' as varchar(50)), " & TextBox1.Text & " " & _
    "UNION ALL " & _
    "select team2, gamedate from ( " & _
    "select team2, gamedate, " & _
    "row_number() over (order by gamedate asc) as rowNumber " & _
    "from nbadb, belt " & _
    "where nbadb.team1 = belt.champ " & _
    "and points2 > points1 " & _
    "and gamedate > startdate " & _
    ") as dt " & _
    "where rowNumber = 1) " & _
    "select top 100 * from belt where startdate < " & TextBox3.Text & " order by startdate desc", myDB)
        Dim dt As New DataTable
        dt.Columns.Add("Champ")
        dt.Columns.Add("Start Time")
        Try
            myDB.Open()
            myReader = sqlCmd.ExecuteReader
            Do While (myReader.Read)
                Dim dr As DataRow = dt.NewRow
                dr("Champ") = myReader.Item("champ")
                dr("Start Time") = myReader.Item("startdate")
                dt.Rows.Add(dr)
            Loop

            myReader.Close()
        Catch ex As Exception
            MsgBox(ex.ToString)
        Finally
            myDB.Close()
        End Try

        GridView1.DataSource = dt
        GridView1.DataBind()
    End Sub
End Class