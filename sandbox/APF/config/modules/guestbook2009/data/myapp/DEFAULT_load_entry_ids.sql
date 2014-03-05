SELECT ent_entry.EntryID AS DB_ID FROM ent_entry
INNER JOIN cmp_guestbook2entry ON ent_entry.EntryID = cmp_guestbook2entry.Target_EntryID
INNER JOIN ent_guestbook ON cmp_guestbook2entry.Source_GuestbookID = ent_guestbook.GuestbookID
WHERE ent_guestbook.GuestbookID = '[GuestbookID]'
ORDER BY ent_entry.CreationTimestamp DESC
LIMIT [Start],[EntriesCount];